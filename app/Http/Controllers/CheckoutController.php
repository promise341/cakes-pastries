<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $discount = 0.00;
        $coupon = session()->get('coupon');

        if ($coupon) {
            $couponModel = \App\Models\Coupon::where('code', $coupon['code'])->first();
            if ($couponModel && $couponModel->isValid()) {
                $discount = $couponModel->calculateDiscount($total);
            } else {
                session()->forget('coupon');
            }
        }

        return view('checkout.index', compact('cart', 'total', 'discount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'required|string|max:20',
            'address'       => 'required|string|max:500',
            'city'          => 'required|string|max:100',
            'notes'         => 'nullable|string|max:1000',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Verify product prices and stock levels server-side
        $total = 0;
        $items = [];
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if (!$product || !$product->isInStock()) {
                return back()->with('error', "'{$item['name']}' is no longer available.");
            }
            if ($product->stock < $item['quantity']) {
                return back()->with('error', "Only {$product->stock} units of '{$item['name']}' are left in stock.");
            }
            $total          += $product->price * $item['quantity'];
            $items[$id]      = array_merge($item, ['price' => $product->price]);
        }

        // Compute discount from applied coupon code
        $discount = 0.00;
        $couponCode = null;
        $couponSession = session()->get('coupon');
        if ($couponSession) {
            $couponModel = \App\Models\Coupon::where('code', $couponSession['code'])->first();
            if ($couponModel && $couponModel->isValid()) {
                $discount = $couponModel->calculateDiscount($total);
                $couponCode = $couponModel->code;
            }
        }

        $finalAmount = max(0.00, $total - $discount);

        try {
            $order = DB::transaction(function () use ($request, $finalAmount, $discount, $couponCode, $items) {
                // Create the order
                $order = Order::create([
                    'customer_name'   => $request->customer_name,
                    'email'           => $request->email,
                    'phone'           => $request->phone,
                    'address'         => $request->address,
                    'city'            => $request->city,
                    'notes'           => $request->notes,
                    'coupon_code'     => $couponCode,
                    'discount_amount' => $discount,
                    'total_amount'    => $finalAmount,
                    'status'          => 'pending',
                    'payment_status'  => 'unpaid',
                ]);

                foreach ($items as $id => $item) {
                    OrderItem::create([
                        'order_id'     => $order->id,
                        'product_id'   => $id,
                        'product_name' => $item['name'],
                        'quantity'     => $item['quantity'],
                        'price'        => $item['price'],
                    ]);
                }

                return $order;
            });
        } catch (\Exception $e) {
            Log::error('Order creation transaction failed: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while creating your order. Please try again.');
        }

        // Clear applied coupon from session upon successful payment redirection initiation
        session()->forget('coupon');

        if ($request->payment_gateway === 'stripe') {
            DB::transaction(function () use ($order) {
                $order->update([
                    'status'            => 'paid',
                    'payment_status'    => 'paid',
                    'payment_reference' => 'stripe_mock_' . uniqid(),
                ]);

                foreach ($order->items as $item) {
                    if ($item->product) {
                        $product = Product::where('id', $item->product_id)->lockForUpdate()->first();
                        $product->decrement('stock', min($item->quantity, $product->stock));
                    }
                }
            });

            // Send confirmation email
            try {
                Mail::to($order->email)->send(new OrderConfirmation($order));
            } catch (\Exception $e) {
                Log::error('Order email failed: ' . $e->getMessage());
            }

            session()->forget('cart');
            return view('checkout.success', compact('order'))->with('success', 'Stripe simulated checkouts processed successfully!');
        }

        // Initialize Paystack transaction
        $response = Http::withToken(config('paystack.secretKey'))
            ->post('https://api.paystack.co/transaction/initialize', [
                'email'        => $request->email,
                'amount'       => (int) ($finalAmount * 100), // Kobo
                'reference'    => $order->order_number,
                'callback_url' => route('checkout.verify'),
                'metadata'     => [
                    'order_id'      => $order->id,
                    'customer_name' => $request->customer_name,
                    'phone'         => $request->phone,
                ],
            ]);

        if (!$response->successful() || !$response->json('status')) {
            Log::error('Paystack init failed', $response->json() ?? []);
            // Atomic cleanup
            $order->delete();
            return back()->with('error', 'Payment initialization failed. Please try again.');
        }

        return redirect($response->json('data.authorization_url'));
    }

    public function verify(Request $request)
    {
        $reference = $request->reference ?? $request->trxref;

        if (!$reference) {
            return redirect()->route('home')->with('error', 'Payment reference missing.');
        }

        $response = Http::withToken(config('paystack.secretKey'))
            ->get("https://api.paystack.co/transaction/verify/{$reference}");

        if (!$response->successful()) {
            return redirect()->route('home')->with('error', 'Could not verify payment.');
        }

        $data = $response->json('data');

        if ($data['status'] !== 'success') {
            return redirect()->route('home')->with('error', 'Payment was not successful.');
        }

        $order = Order::where('order_number', $reference)->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found.');
        }

        // Financial Integrity Safeguard: Verify paid amount matches order total
        $paidAmount = $data['amount'] / 100; // Paystack is in Kobo
        if (abs($paidAmount - $order->total_amount) > 0.01) {
            Log::critical("Payment amount mismatch for Order #{$order->order_number}: Expected {$order->total_amount}, Paid {$paidAmount}");
            return redirect()->route('home')->with('error', 'Payment amount mismatch. Order validation failed.');
        }

        if ($order->payment_status !== 'paid') {
            try {
                DB::transaction(function () use ($order, $reference) {
                    // Lock order row for update to prevent concurrent updates
                    $lockedOrder = Order::where('id', $order->id)->lockForUpdate()->first();
                    
                    if ($lockedOrder->payment_status !== 'paid') {
                        $lockedOrder->update([
                            'status'            => 'paid',
                            'payment_status'    => 'paid',
                            'payment_reference' => $reference,
                        ]);

                        // Decrement stock and verify stock levels
                        foreach ($lockedOrder->items as $item) {
                            if ($item->product) {
                                $product = Product::where('id', $item->product_id)->lockForUpdate()->first();
                                if ($product->stock < $item->quantity) {
                                    Log::critical("Oversold product during checkout verification: Product ID {$product->id}, requested {$item->quantity}, stock {$product->stock}");
                                }
                                $product->decrement('stock', min($item->quantity, $product->stock));
                            }
                        }
                    }
                });
            } catch (\Exception $e) {
                Log::error('Order verify transaction failed: ' . $e->getMessage());
                return redirect()->route('home')->with('error', 'An error occurred during verification.');
            }

            // Send confirmation email outside the transaction block to prevent hanging lock
            try {
                Mail::to($order->email)->send(new OrderConfirmation($order));
            } catch (\Exception $e) {
                Log::error('Order email failed: ' . $e->getMessage());
            }
        }

        session()->forget('cart');

        return view('checkout.success', compact('order'));
    }

    public function track(Request $request)
    {
        $order = null;
        if ($request->filled('order_number')) {
            $order = Order::where('order_number', $request->order_number)
                ->where('email', $request->email)
                ->with('items.product')
                ->first();
        }
        return view('checkout.track', compact('order'));
    }
}
