<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('status', 'active');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
            );
        }

        $products = $query->orderBy('featured', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data'    => $products->through(fn($p) => [
                'id'          => $p->id,
                'name'        => $p->name,
                'slug'        => $p->slug,
                'description' => $p->description,
                'price'       => (float) $p->price,
                'image_url'   => $p->image_url,
                'stock'       => $p->stock,
                'in_stock'    => $p->isInStock(),
                'featured'    => $p->featured,
                'category'    => [
                    'id'   => $p->category->id,
                    'name' => $p->category->name,
                    'slug' => $p->category->slug,
                ],
            ]),
        ]);
    }

    public function show(Product $product)
    {
        abort_if($product->status !== 'active', 404, 'Product not found.');

        $product->load('category');

        return response()->json([
            'success' => true,
            'data'    => [
                'id'          => $product->id,
                'name'        => $product->name,
                'slug'        => $product->slug,
                'description' => $product->description,
                'price'       => (float) $product->price,
                'image_url'   => $product->image_url,
                'stock'       => $product->stock,
                'in_stock'    => $product->isInStock(),
                'featured'    => $product->featured,
                'category'    => [
                    'id'   => $product->category->id,
                    'name' => $product->category->name,
                    'slug' => $product->category->slug,
                ],
            ],
        ]);
    }
}
