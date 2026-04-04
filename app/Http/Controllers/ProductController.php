<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])->latest()->get();
        $categories = Category::all();
        $brands = Brand::all();
        return view('backend.admin.products.index', compact('products', 'categories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'product_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'unit' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        Product::create($request->all());

        return response()->json(['success' => 'Product added successfully.']);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        return response()->json(['product' => $product, 'categories' => $categories, 'brands' => $brands]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'product_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'unit' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return response()->json(['success' => 'Product updated successfully.']);
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
