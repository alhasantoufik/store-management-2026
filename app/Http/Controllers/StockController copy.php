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
                $unitPrice = (float) ($item['price'] ?? $product->sale_price ?? 0);
                $totalPrice = -1 * $unitPrice * $qty; // ❌ negative

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

    public function edit($id)
    {
        $transaction = StockTransaction::with('product')->findOrFail($id);
        $products = Product::all();

        return view('backend.admin.stock.edit', compact('transaction', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $transaction = StockTransaction::findOrFail($id);
            $product = Product::lockForUpdate()->findOrFail($transaction->product_id);

            // 🔥 Step 1: rollback old stock
            if ($transaction->type == 'in') {
                $product->total_stock -= $transaction->quantity;
            } elseif ($transaction->type == 'out') {
                $product->total_stock += $transaction->quantity;
            } elseif ($transaction->type == 'return') {
                $product->total_stock -= $transaction->quantity;
            }

            // 🔥 Step 2: apply new stock
            $newQty = $request->quantity;

            if ($transaction->type == 'in') {
                $product->total_stock += $newQty;
            } elseif ($transaction->type == 'out') {
                if ($newQty > $product->total_stock) {
                    throw new \Exception("Stock not enough!");
                }
                $product->total_stock -= $newQty;
            } elseif ($transaction->type == 'return') {
                $product->total_stock += $newQty;
            }

            // update transaction
            $transaction->update([
                'product_id' => $request->product_id,
                'quantity' => $newQty,
                'current_stock' => $product->total_stock,
            ]);

            $product->save();

            DB::commit();

            return redirect()->route('stock.report')->with('success', 'Updated Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $transaction = StockTransaction::findOrFail($id);
            $product = Product::lockForUpdate()->findOrFail($transaction->product_id);

            // 🔥 rollback stock
            if ($transaction->type == 'in') {
                $product->total_stock -= $transaction->quantity;
            } elseif ($transaction->type == 'out') {
                $product->total_stock += $transaction->quantity;
            } elseif ($transaction->type == 'return') {
                $product->total_stock -= $transaction->quantity;
            }

            $product->save();
            $transaction->delete();

            DB::commit();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error']);
        }
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
}
