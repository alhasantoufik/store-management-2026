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
            return (object)[
                'voucher_no' => $rows->first()->voucher_no,
                'type' => $rows->first()->type,
                'total_qty' => $rows->sum('quantity'),
                'total_sale_price' => $rows->sum('total_price'),
                'total_product_price' => $rows->sum(function ($row) {
                    return $row->quantity * $row->product->product_price;
                }),
                'profit' => $rows->sum('total_price') -
                    $rows->sum(function ($row) {
                        return $row->quantity * $row->product->product_price;
                    }),
            ];
        });

        return view('backend.admin.profit.index', compact('profits'));
    }
}
