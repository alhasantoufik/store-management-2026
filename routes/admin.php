<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PrivilegeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CashBookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CostCategoryController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\CostFieldController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\StockController;

Route::name('admin.')->group(function () {


    // ADMINS
    Route::get('admins', [AdminController::class, 'index'])
        ->name('admins.index')->middleware('privilege:admins,view');

    Route::get('admins/create', [AdminController::class, 'create'])
        ->name('admins.create')->middleware('privilege:admins,create');

    Route::post('admins', [AdminController::class, 'store'])
        ->name('admins.store')->middleware('privilege:admins,create');

    Route::get('admins/edit/{id}', [AdminController::class, 'edit'])
        ->name('admins.edit')->middleware('privilege:admins,edit');

    // ADD THIS ROUTE
    Route::put('admins/{id}', [AdminController::class, 'update'])
        ->name('admins.update')->middleware('privilege:admins,edit');

    Route::delete('admins/{id}', [AdminController::class, 'destroy'])
        ->name('admins.destroy')->middleware('privilege:admins,delete');

    Route::delete('admins/{admin}', [AdminController::class, 'destroy'])
        ->name('admins.destroy')->middleware('privilege:admins,delete');


    // PRIVILEGE MANAGEMENT (INDEPENDENT & FULLY LOCKED)
    Route::get('privileges', [PrivilegeController::class, 'index'])
        ->name('privileges.index')->middleware('privilege:privileges,view');

    Route::post('privileges', [PrivilegeController::class, 'store'])
        ->name('privileges.store')->middleware('privilege:privileges,edit');

    //SMS Settings
    Route::get('/admin/sms/summary', [AdminController::class, 'smsSummary'])
        ->name('sms.summary');

    Route::post('/admin/sms/send-bulk', [AdminController::class, 'sendBulkSms'])
        ->name('sms.bulk.send');

    Route::post('/admin/sms/single', [AdminController::class, 'sendSingleSms'])->name('sms.single.send');
    Route::match(['get', 'post'], '/admin/sms-module', [AdminController::class, 'smsModule'])
        ->name('sms.module');

    Route::get('/admin/send-messages', [AdminController::class, 'sendMessages'])->name('sms.send');
});



// List all categories
Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('categories/{id}/edit-ajax', [CategoryController::class, 'editAjax'])->name('categories.edit.ajax');
Route::put('categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');


Route::prefix('admin')->group(function () {
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::post('/brands/store', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/edit/{id}', [BrandController::class, 'edit'])->name('brands.edit');
    Route::post('/brands/update/{id}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/delete/{id}', [BrandController::class, 'destroy'])->name('brands.delete');
});


Route::prefix('admin')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});


// Stock history route
Route::get('/inventory/logs/{product}', [StockController::class, 'logs'])->name('inventory.logs'); // ✅ match JS



// web.php
Route::prefix('admin')->group(function () {

    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::post('/stock/in', [StockController::class, 'stockIn'])->name('stock.in');
    Route::get('/stock/out', [StockController::class, 'stockOutIndex'])->name('stockOut.index');
    Route::post('/stock/out', [StockController::class, 'stockOut'])->name('stock.out');
    Route::get('/stock/return', [StockController::class, 'stockReturnIndex'])->name('stockReturn.index');



    Route::get('/stock/edit/{id}', [StockController::class, 'edit'])->name('stock.edit');
    Route::post('/stock/update/{id}', [StockController::class, 'update'])->name('stock.update');
    Route::delete('/stock/delete/{id}', [StockController::class, 'delete'])->name('stock.delete');



    Route::get('/stock-invoice/{voucher}', [StockController::class, 'invoice'])->name('stock.invoice');
    Route::get('/stockOut-invoice/{voucher}', [StockController::class, 'stockOutinvoice'])->name('stockOut.invoice');

    Route::get('/stock-return/invoice/{voucher}', [StockController::class, 'stockReturninvoice'])->name('stockReturn.invoice');



    // Correct route for product info
    Route::get('/product-info/{id}', [StockController::class, 'getProductInfo'])->name('admin.product.info');

    Route::post('/stock/return', [StockController::class, 'stockReturn'])->name('stock.return');
    Route::get('/stock/report', [StockController::class, 'stockReport'])->name('stock.report');
});


// Cost Routes
Route::prefix('cost')->group(function () {
    Route::get('/', [CostController::class, 'index'])->name('cost.index');
    Route::post('/store', [CostController::class, 'store'])->name('cost.store');
    Route::get('/edit/{id}', [CostController::class, 'edit'])->name('cost.edit');
    Route::post('/update/{id}', [CostController::class, 'update'])->name('cost.update');
    Route::delete('/delete/{id}', [CostController::class, 'destroy'])->name('cost.delete');
    // All Costs / Reports
    Route::get('cost/all', [CostController::class, 'allCost'])->name('cost.all');

    Route::get('/create', [CostController::class, 'create'])->name('cost.create');
});

Route::get('/expense/allreport', [CostController::class, 'allReport'])->name('expense.report');

// Cost Category Routes
Route::prefix('cost-category')->group(function () {
    Route::get('/', [CostCategoryController::class, 'index'])->name('cost.category.index');
    Route::post('/store', [CostCategoryController::class, 'store'])->name('cost.category.store');
    Route::get('/edit/{id}', [CostCategoryController::class, 'edit'])->name('cost.category.edit');
    Route::post('/update/{id}', [CostCategoryController::class, 'update'])->name('cost.category.update');
    Route::delete('/delete/{id}', [CostCategoryController::class, 'destroy'])->name('cost.category.delete');
});

Route::prefix('cost')->name('cost.')->group(function () {

    Route::get('field', [CostFieldController::class, 'index'])->name('field.index');
    Route::post('field/store', [CostFieldController::class, 'store'])->name('field.store');
    Route::get('field/edit/{id}', [CostFieldController::class, 'edit'])->name('field.edit');
    Route::post('field/update/{id}', [CostFieldController::class, 'update'])->name('field.update');
    Route::delete('field/delete/{id}', [CostFieldController::class, 'destroy'])->name('field.delete');
});

Route::get('cost/get-fields/{id}', function ($id) {
    return \App\Models\CostField::where('cost_category_id', $id)->get();
})->name('cost.get.fields');


Route::get('/profit-report', [ProfitController::class, 'index'])->name('profit.report');
Route::get('cashbook', [CashBookController::class, 'index'])->name('cashbook.index');


Route::prefix('admin')->group(function () {
    Route::get('/all/stocks/index', [StockController::class, 'allindex'])->name('admin.stocks.index');
});



// Stock In Management
Route::prefix('admin')->group(function () {
    Route::get('/stock-in', [StockController::class, 'stockInIndex'])->name('stock.in.index');
    Route::get('/stock-in/edit/{id}', [StockController::class, 'editStockIn'])->name('stock.in.edit');
    Route::post('/stock-in/update/{id}', [StockController::class, 'updateStockIn'])->name('stock.in.update');
    Route::delete('/stock-in/delete/{id}', [StockController::class, 'deleteStockIn'])->name('stock.in.delete');
});

Route::get('/admin/stock-in/search', [StockController::class, 'stockInSearch'])->name('stock.in.search');



// Stock Out Management
Route::prefix('admin')->group(function () {
    Route::get('/stock-out', [StockController::class, 'allstockOutIndex'])->name('stock.out.index');
    Route::get('/stock-out/edit/{id}', [StockController::class, 'editStockOut'])->name('stock.out.edit');
    Route::post('/stock-out/update/{id}', [StockController::class, 'updateStockOut'])->name('stock.out.update');
    Route::delete('/stock-out/delete/{id}', [StockController::class, 'deleteStockOut'])->name('stock.out.delete');
});


Route::get('admin/stock-return/all', [StockController::class, 'allStockReturns'])->name('stockReturn.all');


// routes/web.php
Route::prefix('admin/stock-return')->name('stockReturn.')->group(function () {
    Route::get('all', [StockController::class, 'allStockReturns'])->name('all');
    Route::get('edit/{id}', [StockController::class, 'allreturnedit'])->name('edit');
    Route::put('update/{id}', [StockController::class, 'allreturnupdate'])->name('update');
    Route::delete('delete/{id}', [StockController::class, 'allreturndestroy'])->name('delete');
});




Route::get('stock-in/{voucher_no}', [StockController::class, 'inshow'])->name('stock.in.show');

Route::get('stock-out/{voucher_no}', [StockController::class, 'outshow'])->name('stock.out.show');

Route::get('stock-return/{voucher_no}', [StockController::class, 'returnshow'])->name('stockReturn.show');