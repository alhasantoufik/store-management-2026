<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Cost;
use App\Models\Product;
use App\Models\StockTransaction;
use Carbon\Carbon;
use App\Models\User;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $total_users = User::whereNot('email', 'admin@developer.com')->count();

        // Today's Stock In
        $today_stock_in = StockTransaction::where('type', StockTransaction::TYPE_IN)
            ->whereDate('in_date', Carbon::today())
            ->count();

        // Today's Stock Out
        $today_stock_out = StockTransaction::where('type', StockTransaction::TYPE_OUT)
            ->whereDate('in_date', Carbon::today())
            ->count();

        // Today's Stock Return
        $today_stock_return = StockTransaction::where('type', StockTransaction::TYPE_RETURN)
            ->whereDate('in_date', Carbon::today())
            ->count();

        $todayStockInCost = StockTransaction::where('type', StockTransaction::TYPE_IN)
            ->whereDate('in_date', Carbon::today())
            ->sum('total_price');

        $totalProducts = Product::count();





        // Today's transactions
        $todayTransactions = StockTransaction::whereDate('in_date', Carbon::today())->get();

        $todayStockIn  = $todayTransactions->where('type', StockTransaction::TYPE_IN);
        $todayStockOut = $todayTransactions->where('type', StockTransaction::TYPE_OUT);
        $todayReturns  = $todayTransactions->where('type', StockTransaction::TYPE_RETURN);

        // Sum totals
        $stockInTotal  = $todayStockIn->sum('total_price');
        $stockOutTotal = $todayStockOut->sum('total_price');
        // Make sure returns are positive even if stored negative
        $returnTotal   = $todayReturns->sum(function ($item) {
            return abs($item->total_price);
        });

        // Today's balance
        $todayBalance = $stockInTotal + $returnTotal - $stockOutTotal;










        // Today's Stock Out total price
        $todayStockOutCost = StockTransaction::where('type', StockTransaction::TYPE_OUT)
            ->whereDate('in_date', Carbon::today())
            ->sum('total_price');


        // Today's Stock Return total price (always positive)
        $todayStockReturnCost = abs(
            StockTransaction::where('type', StockTransaction::TYPE_RETURN)
                ->whereDate('in_date', Carbon::today())
                ->sum('total_price')
        );

        return view('backend.layouts.index', [
            'total_users' => $total_users,
            'today_stock_in' => $today_stock_in,
            'today_stock_out' => $today_stock_out,
            'today_stock_return' => $today_stock_return,
            'todayStockInCost' => $todayStockInCost,
            // 'todayProfit' => $todayProfit,
            'totalProducts' => $totalProducts,
            'todayStockOutCost' => $todayStockOutCost,
            'todayStockReturnCost' => $todayStockReturnCost,
            'todayBalance' => $todayBalance,


            
        ]);
    }
}
