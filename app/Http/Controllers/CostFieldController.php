<?php

namespace App\Http\Controllers;

use App\Models\CostCategory;
use App\Models\CostField;
use Illuminate\Http\Request;

class CostFieldController extends Controller
{
    public function index()
    {
        $categories = CostCategory::orderBy('name')->get();
        $fields = CostField::with('category')->latest()->get();

        return view('backend.admin.cost.field_index', compact('categories', 'fields'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cost_category_id' => 'required',
            'name' => 'required'
        ]);

        CostField::create($request->all());

        return response()->json(['success' => 'Field added successfully']);
    }

    public function edit($id)
    {
        return response()->json(CostField::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cost_category_id' => 'required',
            'name' => 'required'
        ]);

        $field = CostField::findOrFail($id);
        $field->update($request->all());

        return response()->json(['success' => 'Updated successfully']);
    }

    public function destroy($id)
    {
        CostField::findOrFail($id)->delete();
        return response()->json(['success' => 'Deleted successfully']);
    }
}
