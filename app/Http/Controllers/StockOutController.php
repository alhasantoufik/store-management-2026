<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockOutController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('product')
            ->where('stock_type', 'out')
            ->latest()
            ->get();

        $products = Product::all();

        return view('backend.admin.stock_out.index', compact('stocks', 'products'));
    }

    // Get current stock
    public function getProductStock($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['current_stock' => 0]);
        }

        return response()->json([
            'current_stock' => $product->current_stock
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // Check stock
        $in = Stock::where('product_id', $request->product_id)->where('stock_type', 'in')->sum('quantity');
        $out = Stock::where('product_id', $request->product_id)->where('stock_type', 'out')->sum('quantity');

        $current = $in - $out;

        if ($request->quantity > $current) {
            return response()->json(['error' => 'Not enough stock!']);
        }

        $stock = Stock::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'stock_type' => 'out',
            'note' => $request->note,
        ]);

        $stock->load('product');

        return response()->json([
            'success' => 'Stock Out successful!',
            'stock' => $stock
        ]);
    }

    public function edit($id)
    {
        return response()->json(Stock::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $stock = Stock::findOrFail($id);
        $stock->update([
            'quantity' => $request->quantity,
            'note' => $request->note,
        ]);

        $stock->load('product');

        return response()->json([
            'success' => 'Stock updated!',
            'stock' => $stock
        ]);
    }

    public function destroy($id)
    {
        $stock = Stock::find($id);

        if ($stock) {
            $stock->delete();
            return response()->json(['success' => 'Deleted successfully']);
        }

        return response()->json(['error' => 'Not found'], 404);
    }
}
