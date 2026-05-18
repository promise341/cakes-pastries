<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featured   = Product::with('category')->where('status', 'active')->where('featured', true)->take(8)->get();
        $categories = Category::withCount(['products' => fn($q) => $q->where('status', 'active')])->get();
        $recent     = Product::with('category')->where('status', 'active')->latest()->take(4)->get();

        return view('home.index', compact('featured', 'categories', 'recent'));
    }
}
