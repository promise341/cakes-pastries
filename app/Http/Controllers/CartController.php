<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart  = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:50']);

        if (!$product->isInStock()) {
            return back()->with('error', 'Sorry, this product is out of stock.');
        }

        $cart     = session()->get('cart', []);
        $quantity = $request->quantity;
        $id       = $product->id;

        if (isset($cart[$id])) {
            $newQuantity = $cart[$id]['quantity'] + $quantity;
            if ($product->stock < $newQuantity) {
                return back()->with('error', "Cannot add more. Only {$product->stock} units of '{$product->name}' are left in stock.");
            }
            $cart[$id]['quantity'] = $newQuantity;
        } else {
            if ($product->stock < $quantity) {
                return back()->with('error', "Only {$product->stock} units of '{$product->name}' are left in stock.");
            }
            $cart[$id] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'image'    => $product->image_url,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', '"' . $product->name . '" added to cart!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:50']);

        $product = Product::find($id);
        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        if ($product->stock < $request->quantity) {
            return back()->with('error', "Only {$product->stock} units of '{$product->name}' are left in stock.");
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cart updated.');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared.');
    }

    public function count()
    {
        $cart = session()->get('cart', []);
        $count = collect($cart)->sum('quantity');
        return response()->json(['count' => $count]);
    }
}
