<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'email'            => 'required|email|max:255',
            'phone'            => 'required|string|max:20',
            'address'          => 'required|string|max:500',
            'city'             => 'required|string|max:100',
            'items'            => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        $total = 0;
        $items = [];

        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);

            if (!$product || !$product->isInStock()) {
                return response()->json([
                    'success' => false,
                    'message' => "Product '{$product?->name}' is unavailable.",
                ], 422);
            }

            $subtotal = $product->price * $item['quantity'];
            $total   += $subtotal;
            $items[]  = [
                'product_id'   => $product->id,
                'product_name' => $product->name,
                'quantity'     => $item['quantity'],
                'price'        => $product->price,
            ];
        }

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'city'          => $request->city,
            'notes'         => $request->notes ?? null,
            'total_amount'  => $total,
            'status'        => 'pending',
            'payment_status'=> 'unpaid',
        ]);

        foreach ($items as $item) {
            OrderItem::create(array_merge($item, ['order_id' => $order->id]));
        }

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully.',
            'data'    => [
                'order_number'  => $order->order_number,
                'total_amount'  => (float) $order->total_amount,
                'status'        => $order->status,
                'payment_status'=> $order->payment_status,
            ],
        ], 201);
    }
}
