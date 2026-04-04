<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    // Show Inventory Page
    public function index()
    {
        $products = Product::with('stocks')->get();
        $stocks = Stock::with('product')->latest()->get();

        // Calculate current stock per product
        $currentStocks = Stock::select('product_id')
            ->selectRaw("SUM(CASE WHEN stock_type='in' THEN quantity ELSE 0 END) - SUM(CASE WHEN stock_type='out' THEN quantity ELSE 0 END) as current_stock")
            ->groupBy('product_id')
            ->pluck('current_stock', 'product_id');

        return view('backend.admin.stock.index', compact('products', 'stocks', 'currentStocks'));
    }

    // Store Stock (In/Out)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'stock_type' => 'required|in:in,out',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $productId = $request->product_id;
        $quantity = $request->quantity;
        $stockType = $request->stock_type;

        // ❗ Stock Out validation
        if ($stockType === 'out') {
            $in = Stock::where('product_id', $productId)->where('stock_type', 'in')->sum('quantity');
            $out = Stock::where('product_id', $productId)->where('stock_type', 'out')->sum('quantity');
            $currentStock = $in - $out;

            if ($quantity > $currentStock) {
                return response()->json([
                    'errors' => ['quantity' => ['Not enough stock!']]
                ]);
            }
        }

        $stock = Stock::create([
            'product_id' => $productId,
            'quantity' => $quantity,
            'stock_type' => $stockType,
            'note' => $request->note,
        ]);

        $stock->load('product');

        return response()->json([
            'success' => 'Stock added successfully!',
            'stock' => $stock
        ]);
    }

    // Fetch Stock for Edit
    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        return response()->json($stock);
    }

    // Update Stock
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'stock_type' => 'required|in:in,out',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $stock = Stock::findOrFail($id);

        // ❗ Stock Out validation
        if ($request->stock_type === 'out') {
            $in = Stock::where('product_id', $request->product_id)->where('stock_type', 'in')->sum('quantity');
            $out = Stock::where('product_id', $request->product_id)->where('stock_type', 'out')->where('id', '!=', $id)->sum('quantity');
            $currentStock = $in - $out;

            if ($request->quantity > $currentStock) {
                return response()->json([
                    'errors' => ['quantity' => ['Not enough stock!']]
                ]);
            }
        }

        $stock->update([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'stock_type' => $request->stock_type,
            'note' => $request->note,
        ]);

        $stock->load('product');

        return response()->json([
            'success' => 'Stock updated successfully!',
            'stock' => $stock
        ]);
    }

    // Delete Stock
    public function destroy($id)
    {
        $stock = Stock::find($id);
        if ($stock) {
            $stock->delete();
            return response()->json(['success' => 'Stock deleted successfully']);
        }
        return response()->json(['error' => 'Stock not found'], 404);
    }

    // Product-wise Stock History
    public function logs($productId)
    {
        $logs = Stock::where('product_id', $productId)->latest()->get();
        return response()->json($logs);
    }
}
