<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->get();
        return view('backend.admin.brand.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands,name',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/brands'), $imageName);
            $imagePath = 'uploads/brands/' . $imageName;
        }

        Brand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagePath
        ]);

        return response()->json(['status' => 'success']);
    }
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return response()->json($brand);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $imagePath = $brand->image;

        if ($request->hasFile('image')) {
            if ($brand->image && file_exists(public_path($brand->image))) {
                unlink(public_path($brand->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/brands'), $imageName);
            $imagePath = 'uploads/brands/' . $imageName;
        }

        $brand->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagePath
        ]);

        return response()->json(['status' => 'updated']);
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand->image && file_exists(public_path($brand->image))) {
            unlink(public_path($brand->image));
        }

        $brand->delete();

        return response()->json(['status' => 'deleted']);
    }
}
