<?php

use App\Http\Controllers\Web\Frontend\PageController;
use App\Http\Controllers\Web\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

//! Route for Landing Page
// Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');

//Dynamic Page
Route::get('/page/privacy-and-policy', [PageController::class, 'privacyAndPolicy'])->name('dynamicPage.privacyAndPolicy');
