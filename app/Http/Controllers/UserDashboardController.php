<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Fetch all orders matching the logged-in user's email
        $orders = Order::where('email', $user->email)
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate summary metrics
        $totalOrders = $orders->count();
        $totalSpent = $orders->where('payment_status', 'paid')->sum('total_amount');
        
        $pendingDeliveries = $orders->where('payment_status', 'paid')
            ->whereIn('status', ['paid', 'processing'])
            ->count();

        $wishlists = $user->wishlists()->with('category')->get();
        $addresses = $user->addresses()->orderBy('is_default', 'desc')->get();

        return view('dashboard.user', compact('orders', 'totalOrders', 'totalSpent', 'pendingDeliveries', 'wishlists', 'addresses'));
    }
}
