<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PrivilegeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockOutController;

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

Route::prefix('admin')->group(function () {
    Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::post('/stocks/store', [StockController::class, 'store'])->name('stocks.store');
    Route::get('/stocks/edit/{id}', [StockController::class, 'edit'])->name('stocks.edit');
    Route::post('/stocks/update/{id}', [StockController::class, 'update'])->name('stocks.update');
    Route::delete('/stocks/destroy/{id}', [StockController::class, 'destroy'])->name('stocks.destroy'); // ✅ match JS
});

// Stock history route
Route::get('/inventory/logs/{product}', [StockController::class, 'logs'])->name('inventory.logs'); // ✅ match JS