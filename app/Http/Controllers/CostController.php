<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\CostCategory;
use Illuminate\Http\Request;
use App\Models\CostField;

class CostController extends Controller
{
    public function index(Request $request)
    {
        $fields = CostField::all();
        $categories = CostCategory::orderBy('name')->get();
        $costs = Cost::with(['category', 'field'])->latest();

        if ($request->filled('category_id')) {
            $costs->where('cost_category_id', $request->category_id);
        }

        if ($request->filled('field_id')) {
            $costs->where('cost_field_id', $request->field_id); // ✅ Filter by field
        }

        if ($request->filled('from') && $request->filled('to')) {
            $costs->whereBetween('date', [$request->from, $request->to]);
        }

        $costs = $costs->get();
        return view('backend.admin.cost.index', compact('categories', 'fields', 'costs'));
    }

    public function create()
    {
        $fields = CostField::all();
        $categories = CostCategory::orderBy('name')->get();

        return view('backend.admin.cost.create', compact('fields', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cost_category_id' => 'required|exists:cost_categories,id',
            'cost_field_id' => 'required|exists:cost_fields,id', // ✅ new
            'amount' => 'required|numeric',
            'cost_by' => 'required|string|max:255',
            'date' => 'required|date'
        ]);

        Cost::create($request->all());
        return response()->json(['success' => 'Cost added successfully']);
    }

    public function edit($id)
    {
        $cost = Cost::findOrFail($id);
        return response()->json($cost);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cost_category_id' => 'required|exists:cost_categories,id',
            'cost_field_id' => 'required|exists:cost_fields,id',
            'amount' => 'required|numeric',
            'cost_by' => 'required|string|max:255',
            'date' => 'required|date'
        ]);

        $cost = Cost::findOrFail($id);
        $cost->update($request->all());
        return response()->json(['success' => 'Cost updated successfully']);
    }

    public function destroy($id)
    {
        Cost::findOrFail($id)->delete();
        return response()->json(['success' => 'Cost deleted successfully']);
    }

    public function allCost(Request $request)
    {
        $categories = CostCategory::orderBy('name')->get();
        $fields = CostField::orderBy('name')->get(); // ✅ NEW

        $costBys = Cost::select('cost_by')->distinct()->pluck('cost_by');

        $query = Cost::with(['category', 'field'])->latest(); // ✅ update

        if ($request->filled('category_id')) {
            $query->where('cost_category_id', $request->category_id);
        }

        if ($request->filled('cost_field_id')) { // ✅ NEW
            $query->where('cost_field_id', $request->cost_field_id);
        }

        if ($request->filled('cost_by')) {
            $query->where('cost_by', $request->cost_by);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('date', [$request->from, $request->to]);
        }

        $costs = $query->paginate(50);

        return view('backend.admin.cost.all', compact('costs', 'categories', 'fields', 'costBys'));
    }

    public function allReport(Request $request)
    {
        $categories = CostCategory::orderBy('name')->get();
        $fields = CostField::orderBy('name')->get(); // ✅ NEW

        $costBys = Cost::select('cost_by')->distinct()->pluck('cost_by');

        $query = Cost::with(['category', 'field'])->latest(); // ✅ update

        if ($request->filled('category_id')) {
            $query->where('cost_category_id', $request->category_id);
        }

        if ($request->filled('cost_field_id')) { // ✅ NEW
            $query->where('cost_field_id', $request->cost_field_id);
        }

        if ($request->filled('cost_by')) {
            $query->where('cost_by', $request->cost_by);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('date', [$request->from, $request->to]);
        }

        $costs = $query->paginate(50);

        return view('backend.admin.cost.reportcost', compact('costs', 'categories', 'fields', 'costBys'));
    }
}
