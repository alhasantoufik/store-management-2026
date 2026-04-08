<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CashBookController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();

        $query = StockTransaction::with('product')->orderBy('in_date', 'desc');

        // 🔹 Default: show today if no filter is set
        if (!$request->filled('days') && !$request->filled('start_date') && !$request->filled('end_date')) {
            $query->whereDate('in_date', Carbon::today());
        }

        // Quick range filter via button
        if ($request->filled('days')) {
            $startDate = Carbon::now()->subDays($request->days)->format('Y-m-d');
            $query->whereDate('in_date', '>=', $startDate);
        }

        // Filter by product
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('in_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('in_date', '<=', $request->end_date);
        }

        $transactions = $query->get();

        // Separate by type
        $stockIn    = $transactions->where('type', StockTransaction::TYPE_IN);
        $stockOut   = $transactions->where('type', StockTransaction::TYPE_OUT);
        $returns    = $transactions->where('type', StockTransaction::TYPE_RETURN);

        // Totals
        $totalCost   = $stockIn->sum('total_price');
        $totalIncome = $stockOut->sum('total_price') + $returns->sum('total_price');
        $profit      = $totalIncome - $totalCost;

        return view('backend.admin.cashbook.index', compact(
            'products',
            'stockIn',
            'stockOut',
            'returns',
            'totalCost',
            'totalIncome',
            'profit'
        ));
    }
}
