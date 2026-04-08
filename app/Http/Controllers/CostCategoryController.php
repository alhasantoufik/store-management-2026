<?php
namespace App\Http\Controllers;

use App\Models\CostCategory;
use Illuminate\Http\Request;

class CostCategoryController extends Controller {
    public function index() {
        $categories = CostCategory::orderBy('name')->get();
        return view('backend.admin.cost.category_index', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|unique:cost_categories,name']);
        CostCategory::create($request->all());
        return response()->json(['success' => 'Category added successfully']);
    }

    public function edit($id) {
        $category = CostCategory::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id) {
        $request->validate(['name' => 'required|unique:cost_categories,name,'.$id]);
        $category = CostCategory::findOrFail($id);
        $category->update($request->all());
        return response()->json(['success' => 'Category updated successfully']);
    }

    public function destroy($id) {
        CostCategory::findOrFail($id)->delete();
        return response()->json(['success' => 'Category deleted successfully']);
    }
}