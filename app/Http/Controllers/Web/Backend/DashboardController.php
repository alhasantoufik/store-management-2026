<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
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



        // Today's transactions (type in, out, return)
        $todayTransactions = StockTransaction::whereDate('in_date', Carbon::today())->get();

        $todayStockIn   = $todayTransactions->where('type', StockTransaction::TYPE_IN);
        $todayStockOut  = $todayTransactions->where('type', StockTransaction::TYPE_OUT);
        $todayReturns   = $todayTransactions->where('type', StockTransaction::TYPE_RETURN);

        $todayTotalCost   = $todayStockIn->sum('total_price');
        $todayTotalIncome = $todayStockOut->sum('total_price') + $todayReturns->sum('total_price');
        $todayProfit      = $todayTotalIncome - $todayTotalCost;

        return view('backend.layouts.index', [
            'total_users' => $total_users,
            'today_stock_in' => $today_stock_in,
            'today_stock_out' => $today_stock_out,
            'today_stock_return' => $today_stock_return,
            'todayStockInCost' => $todayStockInCost,
            'todayProfit' => $todayProfit,
            'totalProducts' => $totalProducts,
        ]);
    }
}
