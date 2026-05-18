<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function toggle(Product $product)
    {
        $user = Auth::user();
        
        $result = $user->wishlists()->toggle($product->id);
        
        $isAdded = count($result['attached']) > 0;
        
        $message = $isAdded 
            ? "{$product->name} added to your wishlist successfully!"
            : "{$product->name} removed from your wishlist.";

        return back()->with('success', $message);
    }
}
