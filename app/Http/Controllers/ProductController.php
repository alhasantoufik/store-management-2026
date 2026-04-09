<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $brands = Brand::all();

        // If AJAX request for live search
        if ($request->ajax() && $request->has('search')) {
            $search = $request->search;
            $products = Product::with(['category', 'brand'])
                ->where('name', 'like', "%{$search}%")
                ->latest()
                ->get();

            // Return JSON with rendered rows
            $html = view('backend.admin.products.partials.product_rows', compact('products'))->render();
            return response()->json(['html' => $html]);
        }

        // Default: load all products
        $products = Product::with(['category', 'brand'])->latest()->get();
        return view('backend.admin.products.index', compact('products', 'categories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'product_code' => 'nullable|string|max:100', // ✅ add
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'product_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'unit' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048', // max 2MB
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $data['image'] = 'uploads/products/' . $filename;
        }

        Product::create($data);

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
            'product_code' => 'nullable|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'product_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'unit' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $data['image'] = 'uploads/products/' . $filename;
        }

        $product->update($data);

        return response()->json(['success' => 'Product updated successfully.']);
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
