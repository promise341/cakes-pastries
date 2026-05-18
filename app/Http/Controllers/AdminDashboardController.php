<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Analytics Summary Metrics
        $totalSales = Order::where('payment_status', 'paid')->sum('total_amount');
        $activeProductsCount = Product::where('status', 'active')->count();
        $totalUsersCount = User::count();
        $pendingOrdersCount = Order::where('status', 'pending')->count();

        // Fetch recent orders list
        $orders = Order::with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('dashboard.admin', compact(
            'totalSales', 
            'activeProductsCount', 
            'totalUsersCount', 
            'pendingOrdersCount', 
            'orders'
        ));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processing,delivered,cancelled',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return back()->with('success', "Order #{$order->order_number} status updated to '{$request->status}' successfully!");
    }
}
