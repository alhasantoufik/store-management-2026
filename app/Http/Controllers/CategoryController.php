<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('backend.admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/category'), $imageName);
        }

        Category::create([
            'title'  => $request->title,
            'slug'   => Str::slug($request->title),
            'image'  => $imageName,
            'status' => $request->status ?? 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Category added successfully']);
    }

    public function editAjax($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imageName = $category->image;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image && file_exists(public_path('uploads/category/' . $category->image))) {
                unlink(public_path('uploads/category/' . $category->image));
            }

            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/category'), $imageName);
        }

        $category->update([
            'title'  => $request->title,
            'slug'   => Str::slug($request->title),
            'image'  => $imageName,
            'status' => $request->status ?? $category->status,
        ]);

        return response()->json(['success' => true, 'message' => 'Category updated successfully']);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image && file_exists(public_path('uploads/category/' . $category->image))) {
            unlink(public_path('uploads/category/' . $category->image));
        }

        $category->delete();

        return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
    }
}