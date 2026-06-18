<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\DashboardController;

// ─── Public Routes ────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [ProductController::class, 'search'])->name('search');

// Products
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Categories
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Comparisons
Route::get('/compare', [ComparisonController::class, 'index'])->name('compare');
Route::post('/compare', [ComparisonController::class, 'store'])->name('compare.store');

// ─── Authenticated Routes ──────────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/watchlist/add', [DashboardController::class, 'addToWatchlist'])->name('watchlist.add');
    Route::delete('/watchlist/{productId}', [DashboardController::class, 'removeFromWatchlist'])->name('watchlist.remove');
    Route::post('/comparisons/save', [ComparisonController::class, 'save'])->name('comparisons.save');
    Route::post('/alerts', [DashboardController::class, 'createAlert'])->name('alerts.store');
    Route::delete('/alerts/{id}', [DashboardController::class, 'deleteAlert'])->name('alerts.destroy');
});

// ─── Auth Routes (Laravel Breeze) ─────────────────────────────────────────────
require __DIR__.'/auth.php';
