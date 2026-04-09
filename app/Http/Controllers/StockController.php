<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('backend.admin.stock.index', compact('products'));
    }

    public function getProductInfo($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'stock' => 0,
                'price' => 0,
                'sale_price' => 0,
            ]);
        }

        return response()->json([
            'stock' => (int) ($product->total_stock ?? 0),
            'price' => (float) ($product->product_price ?? 0),
            'sale_price' => (float) ($product->sale_price ?? 0),
        ]);
    }

    public function stockIn(Request $request)
    {
        $request->validate([
            'transaction_date' => 'nullable|date',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $transactionDate = $request->transaction_date ?? now();

        DB::beginTransaction();

        try {
            $datePrefix = 'IN' . date('Ym', strtotime($transactionDate));

            $lastVoucher = StockTransaction::where('voucher_no', 'like', $datePrefix . '%')
                ->orderBy('voucher_no', 'desc')
                ->first();

            if ($lastVoucher) {
                $lastSerial = (int) substr($lastVoucher->voucher_no, -5);
                $newSerial = str_pad($lastSerial + 1, 5, '0', STR_PAD_LEFT);
            } else {
                $newSerial = '0001';
            }

            $voucherNo = $datePrefix . $newSerial;

            foreach ($request->products as $item) {

                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                $prevStock = $product->total_stock ?? 0;
                $qty = (int)$item['quantity'];
                $newStock = $prevStock + $qty;

                $unitPrice = $item['price'] ?? $product->product_price ?? 0;
                $totalPrice = $unitPrice * $qty;

                StockTransaction::create([
                    'voucher_no'     => $voucherNo,
                    'product_id'     => $product->id,
                    'type'           => 'in',
                    'previous_stock' => $prevStock,
                    'quantity'       => $qty,
                    'current_stock'  => $newStock,
                    'total_price'    => $totalPrice,
                    'in_date'        => $transactionDate,
                    'note'           => 'Stock In',
                ]);

                $product->update([
                    'total_stock' => $newStock
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'voucher' => $voucherNo,
                'redirect' => route('stock.invoice', $voucherNo)
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function invoice($voucher)
    {
        $transactions = StockTransaction::with('product')
            ->where('voucher_no', $voucher)
            ->get();

        $grandTotal = $transactions->sum('total_price');

        $comapnyInfo = SystemSetting::first(); // Assuming you have company info in system settings

        return view('backend.admin.stock.invoice', compact(
            'transactions',
            'voucher',
            'grandTotal',
            'comapnyInfo'
        ));
    }


    public function stockOutIndex()
    {
        $products = Product::all();
        return view('backend.admin.stock.stockOut', compact('products'));
    }


    public function stockOut(Request $request)
    {
        $request->validate([
            'transaction_date' => 'nullable|date',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $transactionDate = $request->transaction_date ?? now();

        DB::beginTransaction();

        try {
            // 🔥 Step 1: Voucher Generate (OUT prefix)
            $datePrefix = 'OUT' . date('Ym', strtotime($transactionDate));

            $lastVoucher = StockTransaction::where('voucher_no', 'like', $datePrefix . '%')
                ->orderBy('voucher_no', 'desc')
                ->first();

            if ($lastVoucher) {
                $lastSerial = (int) substr($lastVoucher->voucher_no, -5);
                $newSerial = str_pad($lastSerial + 1, 5, '0', STR_PAD_LEFT);
            } else {
                $newSerial = '0001';
            }

            $voucherNo = $datePrefix . $newSerial;

            // 🔥 Step 2: Loop Products
            foreach ($request->products as $item) {

                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                $prevStock = (int) ($product->total_stock ?? 0);
                $qty = (int) $item['quantity'];

                // ❗ Stock validation
                if ($qty > $prevStock) {
                    throw new \Exception("Stock not enough for {$product->name}");
                }

                $newStock = $prevStock - $qty;

                $unitPrice = (float) ($item['price'] ?? $product->sale_price ?? 0);
                $totalPrice = $unitPrice * $qty;

                StockTransaction::create([
                    'voucher_no'     => $voucherNo, // ✅ Added
                    'product_id'     => $product->id,
                    'type'           => 'out',
                    'previous_stock' => $prevStock,
                    'quantity'       => $qty,
                    'current_stock'  => $newStock,
                    'total_price'    => $totalPrice,
                    'in_date'        => $transactionDate,
                    'note'           => 'Stock Out',
                ]);

                $product->total_stock = $newStock;
                $product->save();
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'voucher' => $voucherNo,
                'redirect' => route('stockOut.invoice', $voucherNo)
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function stockOutinvoice($voucher)
    {
        $transactions = StockTransaction::with('product')
            ->where('voucher_no', $voucher)
            ->get();

        $grandTotal = $transactions->sum('total_price');

        $comapnyInfo = SystemSetting::first(); // Assuming you have company info in system settings

        return view('backend.admin.stock.stockOutInvoice', compact(
            'transactions',
            'voucher',
            'grandTotal',
            'comapnyInfo'
        ));
    }


    // Show all stock-out transactions
    public function allstockOutIndex(Request $request)
    {
        $query = StockTransaction::where('type', StockTransaction::TYPE_OUT)
            ->select(
                'voucher_no',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(total_price) as total_price'),
                'in_date'
            )
            ->groupBy('voucher_no', 'in_date')
            ->orderBy('in_date', 'desc');

        // Voucher search
        if ($request->filled('voucher_no')) {
            $query->where('voucher_no', 'like', '%' . $request->voucher_no . '%');
        }

        // Date range filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('in_date', [$request->start_date, $request->end_date]);
        }

        $stockOuts = $query->get();

        return view('backend.admin.stock.stockout.index', compact('stockOuts'));
    }

    public function outshow($voucherNo)
{
    // Get all stock out items for this voucher
    $stockItems = StockTransaction::with('product')
        ->where('type', StockTransaction::TYPE_OUT)
        ->where('voucher_no', $voucherNo)
        ->get();

    if ($stockItems->isEmpty()) {
        return redirect()->back()->with('error', 'No stock out found for this voucher.');
    }

    return view('backend.admin.stock.stockout.show', compact('stockItems', 'voucherNo'));
}

    // Edit stock-out transaction
    public function editStockOut($voucher_no)
    {
        // Fetch all stock-outs under this voucher
        $stocks = StockTransaction::with('product')
            ->where('type', StockTransaction::TYPE_OUT)
            ->where('voucher_no', $voucher_no)
            ->get();

        if ($stocks->isEmpty()) {
            abort(404, 'Voucher not found');
        }

        return view('backend.admin.stock.stockout.edit', compact('stocks', 'voucher_no'));
    }

    // Update stock-out transaction
    public function updateStockOut(Request $request, $voucher_no)
    {
        $request->validate([
            'stocks.*.id' => 'required|exists:stock_transactions,id',
            'stocks.*.quantity' => 'required|integer|min:1',
            'stocks.*.price' => 'required|numeric|min:0',
            'stocks.*.note' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->stocks as $stockData) {
                $stock = StockTransaction::lockForUpdate()->findOrFail($stockData['id']);
                if ($stock->type !== StockTransaction::TYPE_OUT) {
                    abort(403, 'Invalid stock type');
                }

                $product = Product::lockForUpdate()->findOrFail($stock->product_id);

                // Calculate new stock
                $newStock = $product->total_stock + $stock->quantity - $stockData['quantity'];
                if ($newStock < 0) {
                    throw new \Exception("Not enough stock for product {$product->name}");
                }

                // Update product stock
                $product->update(['total_stock' => $newStock]);

                // Update stock transaction
                $stock->update([
                    'quantity' => $stockData['quantity'],
                    'total_price' => $stockData['quantity'] * $stockData['price'],
                    'current_stock' => $newStock,
                    'note' => $stockData['note'],
                ]);
            }
        });

        return redirect()->route('stock.out.index')->with('success', 'Voucher updated successfully');
    }

    // Delete stock-out transaction
    public function deleteStockOut($voucher_no)
    {
        DB::transaction(function () use ($voucher_no) {
            // Get all stock out records for this voucher
            $stocks = StockTransaction::lockForUpdate()
                ->where('voucher_no', $voucher_no)
                ->where('type', StockTransaction::TYPE_OUT)
                ->get();

            if ($stocks->isEmpty()) {
                abort(404, 'Voucher not found');
            }

            foreach ($stocks as $stock) {
                // Revert product stock
                $product = Product::lockForUpdate()->findOrFail($stock->product_id);
                $product->update(['total_stock' => $product->total_stock + $stock->quantity]);

                // Delete the stock transaction
                $stock->delete();
            }
        });

        return response()->json(['status' => 'success']);
    }


    public function stockReturnIndex()
    {
        $products = Product::all();
        return view('backend.admin.stock.return', compact('products'));
    }


    public function stockReturn(Request $request)
    {
        $request->validate([
            'transaction_date' => 'nullable|date',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $transactionDate = $request->transaction_date ?? now();

        DB::beginTransaction();

        try {
            // 🔥 Step 1: Voucher Generate (RET prefix)
            $datePrefix = 'RET' . date('Ym', strtotime($transactionDate));

            $lastVoucher = StockTransaction::where('voucher_no', 'like', $datePrefix . '%')
                ->orderBy('voucher_no', 'desc')
                ->first();

            $newSerial = $lastVoucher
                ? str_pad((int) substr($lastVoucher->voucher_no, -5) + 1, 5, '0', STR_PAD_LEFT)
                : '00001';

            $voucherNo = $datePrefix . $newSerial;

            // 🔥 Step 2: Loop Products
            foreach ($request->products as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                $prevStock = (int) ($product->total_stock ?? 0);
                $qty = (int) $item['quantity'];

                // 👉 Stock increase for return
                $newStock = $prevStock + $qty;

                // Unit price stays positive, but total_price should be negative
                $unitPrice = (float) ($item['price'] ?? $product->product_price ?? 0);
                $totalPrice = -1 * $unitPrice * $qty; // negative

                StockTransaction::create([
                    'voucher_no'     => $voucherNo,
                    'product_id'     => $product->id,
                    'type'           => StockTransaction::TYPE_RETURN,
                    'previous_stock' => $prevStock,
                    'quantity'       => $qty,
                    'current_stock'  => $newStock,
                    'total_price'    => $totalPrice, // negative
                    'in_date'        => $transactionDate,
                    'note'           => 'Stock Return',
                ]);

                // Update product stock
                $product->total_stock = $newStock;
                $product->save();
            }

            DB::commit();
            return back()->with('success', 'Stock Returned Successfully. Voucher: ' . $voucherNo);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong! ' . $e->getMessage());
        }
    }




    public function allStockReturns(Request $request)
    {
        $query = StockTransaction::where('type', StockTransaction::TYPE_RETURN)
            ->selectRaw('voucher_no, SUM(quantity) as total_qty, SUM(total_price) as total_price, MAX(in_date) as in_date')
            ->groupBy('voucher_no');

        // Filter by voucher_no (live search)
        if ($request->filled('voucher_no')) {
            $voucher = $request->voucher_no;
            $query->where('voucher_no', 'like', "%{$voucher}%");
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = $request->start_date;
            $end = $request->end_date;
            $query->whereBetween('in_date', [$start, $end]);
        }

        $returns = $query->orderBy('in_date', 'desc')->get();

        return view('backend.admin.stock.stockreturn.index', compact('returns'));
    }

    public function returnshow($voucherNo)
{
    // Get all stock return items for this voucher
    $stockItems = StockTransaction::with('product')
        ->where('type', StockTransaction::TYPE_RETURN)
        ->where('voucher_no', $voucherNo)
        ->get();

    if ($stockItems->isEmpty()) {
        return redirect()->back()->with('error', 'No stock return found for this voucher.');
    }

    return view('backend.admin.stock.stockreturn.show', compact('stockItems', 'voucherNo'));
}

    public function allreturnedit($voucher_no)
    {
        // Get all returns with this voucher
        $returns = StockTransaction::where('voucher_no', $voucher_no)
            ->where('type', StockTransaction::TYPE_RETURN)
            ->with('product')
            ->get();

        $products = Product::all();

        return view('backend.admin.stock.stockreturn.edit', compact('returns', 'products', 'voucher_no'));
    }


    public function allreturnupdate(Request $request, $voucher_no)
    {
        $request->validate([
            'products.*.id'        => 'required|exists:stock_transactions,id',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity'  => 'required|integer|min:1',
            'products.*.price'     => 'required|numeric|min:0',
            'in_date'              => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->products as $item) {
                $return = StockTransaction::findOrFail($item['id']);
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                // Revert previous stock
                $product->total_stock -= $return->quantity;

                // Apply new stock
                $product->total_stock += $item['quantity'];

                $return->update([
                    'product_id'    => $item['product_id'],
                    'quantity'      => $item['quantity'],
                    'total_price'   => -1 * $item['price'] * $item['quantity'], // negative for return
                    'current_stock' => $product->total_stock,
                    'in_date'       => $request->in_date,
                ]);

                $product->save();
            }

            DB::commit();
            return redirect()->route('stockReturn.all')->with('success', 'All Stock Returns Updated Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong! ' . $e->getMessage());
        }
    }


    public function allreturndestroy($id)
    {
        DB::beginTransaction();
        try {
            $return = StockTransaction::findOrFail($id);
            $product = Product::lockForUpdate()->findOrFail($return->product_id);

            // Revert stock
            $product->total_stock -= $return->quantity;
            $product->save();

            $return->delete();

            DB::commit();
            return redirect()->route('stockReturn.all')->with('success', 'Stock Return Deleted Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong! ' . $e->getMessage());
        }
    }





    public function stockReport(Request $request)
    {
        $products = Product::all(); // filter dropdown

        // Query builder
        $query = StockTransaction::with('product')->orderBy('id', 'desc');

        // Filter by product
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('in_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('in_date', '<=', $request->end_date);
        }

        // 🔍 Filter by voucher_no
        if ($request->filled('voucher_no')) {
            $query->where('voucher_no', 'like', '%' . $request->voucher_no . '%');
        }

        $transactions = $query->paginate(50)->withQueryString();

        return view('backend.admin.stock.report', compact('transactions', 'products'));
    }


    public function allindex(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        // Apply filters if present in query params
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->brand_id) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->product_id) {
            $query->where('id', $request->product_id);
        }

        $products = $query->latest()->get();

        $categories = \App\Models\Category::all();
        $brands = \App\Models\Brand::all();

        return view('backend.admin.stock.allstockindex', compact('products', 'categories', 'brands'));
    }


    // Show all stock-in transactions
    public function stockInIndex()
    {
        // Group by voucher_no and calculate totals
        $stockIns = StockTransaction::where('type', StockTransaction::TYPE_IN)
            ->select(
                'voucher_no',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(total_price) as total_price'),
                'in_date'
            )
            ->groupBy('voucher_no', 'in_date')
            ->orderBy('in_date', 'desc')
            ->get();

        return view('backend.admin.stock.stockin.stock_in', compact('stockIns'));
    }

    public function inshow($voucherNo)
    {
        // Get all stock in items for this voucher
        $stockItems = StockTransaction::with('product')
            ->where('type', StockTransaction::TYPE_IN)
            ->where('voucher_no', $voucherNo)
            ->get();

        if ($stockItems->isEmpty()) {
            return redirect()->back()->with('error', 'No stock found for this voucher.');
        }

        return view('backend.admin.stock.stockin.show', compact('stockItems', 'voucherNo'));
    }

    public function stockInSearch(Request $request)
    {
        $query = StockTransaction::where('type', StockTransaction::TYPE_IN);

        // Search by voucher number
        if ($request->filled('voucher_no')) {
            $query->where('voucher_no', 'like', '%' . $request->voucher_no . '%');
        }

        // Filter by date range
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('in_date', [
                $request->from_date,
                $request->to_date
            ]);
        }

        $stockIns = $query->select(
            'voucher_no',
            DB::raw('SUM(quantity) as total_quantity'),
            DB::raw('SUM(total_price) as total_price'),
            'in_date'
        )
            ->groupBy('voucher_no', 'in_date')
            ->orderBy('in_date', 'desc')
            ->get();

        // Return only the table rows HTML
        return view('backend.admin.stock.stockin.partials.stock_in_rows', compact('stockIns'))->render();
    }

    // Edit stock-in transaction
    public function editStockIn($voucherNo)
    {
        $stocks = StockTransaction::with('product')
            ->where('type', StockTransaction::TYPE_IN)
            ->where('voucher_no', $voucherNo)
            ->get();

        if ($stocks->isEmpty()) {
            abort(404, 'Voucher not found');
        }

        return view('backend.admin.stock.stockin.edit_stock_in', compact('stocks', 'voucherNo'));
    }

    // Update stock-in transaction
    public function updateStockIn(Request $request, $voucherNo)
    {
        $request->validate([
            'quantity.*' => 'required|integer|min:1',
            'price.*' => 'required|numeric|min:0',
            'note.*' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $voucherNo) {
            $stocks = StockTransaction::lockForUpdate()
                ->where('type', StockTransaction::TYPE_IN)
                ->where('voucher_no', $voucherNo)
                ->get();

            foreach ($stocks as $stock) {
                $product = Product::lockForUpdate()->findOrFail($stock->product_id);

                $newStock = $product->total_stock - $stock->quantity + $request->quantity[$stock->id];

                $product->update(['total_stock' => $newStock]);

                $stock->update([
                    'quantity' => $request->quantity[$stock->id],
                    'total_price' => $request->quantity[$stock->id] * $request->price[$stock->id],
                    'current_stock' => $newStock,
                    'note' => $request->note[$stock->id] ?? $stock->note,
                ]);
            }
        });

        return redirect()->route('stock.in.index')->with('success', 'Stock updated successfully');
    }

    // Delete stock-in transaction
    public function deleteStockIn($voucherNo)
    {
        DB::transaction(function () use ($voucherNo) {
            $stocks = StockTransaction::lockForUpdate()
                ->where('type', StockTransaction::TYPE_IN)
                ->where('voucher_no', $voucherNo)
                ->get();

            if ($stocks->isEmpty()) {
                abort(404, 'Voucher not found');
            }

            foreach ($stocks as $stock) {
                $product = Product::lockForUpdate()->findOrFail($stock->product_id);

                // Adjust total_stock
                $newStock = $product->total_stock - $stock->quantity;
                $product->update(['total_stock' => $newStock]);

                $stock->delete();
            }
        });

        return response()->json(['status' => 'success']);
    }
}
