<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockTransaction;

class ProfitController extends Controller
{
    public function index(Request $request)
    {
        $query = StockTransaction::with('product')
            ->whereIn('type', ['out', 'return']);

        // 🔍 Voucher filter
        if ($request->filled('voucher_no')) {
            $query->where('voucher_no', 'like', '%' . $request->voucher_no . '%');
        }

        // 📅 Date range filter
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('in_date', [
                $request->from_date,
                $request->to_date
            ]);
        }

        $transactions = $query->orderBy('in_date', 'desc')->get();

        // Group by voucher
        $profits = $transactions->groupBy('voucher_no')->map(function ($rows) {
            $type = $rows->first()->type;

            $totalQty = $rows->sum('quantity');
            $totalSalePrice = $rows->sum('total_price');
            $totalPurchasePrice = $rows->sum(function ($row) {
                return $row->quantity * $row->product->product_price;
            });

            // 🔥 Profit logic
            if ($type === 'return') {
                $profit = abs($totalSalePrice + $totalPurchasePrice); // always positive
            } else {
                $profit = $totalSalePrice - $totalPurchasePrice;
            }

            return (object)[
                'voucher_no' => $rows->first()->voucher_no,
                'type' => $type,
                'total_qty' => $totalQty,
                'total_sale_price' => $totalSalePrice,
                'total_product_price' => $totalPurchasePrice,
                'profit' => $profit,
            ];
        });

        return view('backend.admin.profit.index', compact('profits'));
    }
}
