<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryManagerController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('created_at', 'desc')->get();
        return view('admin.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return back()->with('success', "Pastry Category '{$request->name}' added successfully!");
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return back()->with('success', "Pastry Category '{$category->name}' updated successfully!");
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', "Cannot delete category '{$category->name}' because it contains registered products.");
        }

        $name = $category->name;
        $category->delete();
        return back()->with('success', "Category '{$name}' deleted.");
    }
}
