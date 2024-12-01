<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;



Route::get('/dashboard/download-report', [DashboardController::class, 'downloadReport'])->name('dashboard.download-report');

Route::get('/home', [HomeController::class, 'index'])->name('home.index');

Route::patch('/discounts/{discount}/toggle', [DiscountController::class, 'toggle'])->name('discounts.toggle');
/*
|----------------------------------------------------------------------
| Public Routes
|----------------------------------------------------------------------
*/
Route::resource('contacts', ContactController::class);
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store'); // Create category
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update'); // Update category
Route::resource('categories', CategoryController::class)->except(['show']);
Route::patch('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');


/*
|----------------------------------------------------------------------
| Authentication Required Routes
|----------------------------------------------------------------------
*/
Route::middleware(['auth', 'auth.role'])->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Review Routes
    Route::prefix('reviews')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('reviews.index');
        Route::post('/', [ReviewController::class, 'store'])->name('reviews.store');
        Route::get('/{id}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
        Route::post('/{review}/toggle-active', [ReviewController::class, 'toggleActive'])->name('reviews.toggleActive');
        Route::patch('{review}/status', [ReviewController::class, 'updateStatus'])->name('reviews.updateStatus');
    });

    // Order Routes
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/search', [OrderController::class, 'search'])->name('orders.search');
        Route::get('/export', [OrderController::class, 'export'])->name('orders.export');
        Route::get('/{order}', [OrderController::class, 'view'])->name('orders.view');
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::patch('/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::put('/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::get('/order/{id}', [OrderController::class, 'view'])->name('order.view');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::get('/orders/export', [OrderController::class, 'export'])->name('orders.export');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/export', [OrderController::class, 'exportOrders'])->name('orders.export');
    });
});

/*
|----------------------------------------------------------------------
| Admin Routes (Auth + Role Required)
|----------------------------------------------------------------------
*/
Route::middleware(['auth', 'auth.role'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('dashboard')->group(function () {
        // User Management
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::get('/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/', [UserController::class, 'store'])->name('users.store');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
            Route::get('/users/{user}', [UserController::class, 'view'])->name('users.view');
            Route::patch('/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggleActive');
        });

        // Product Management
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('products.index');
            Route::get('/create', [ProductController::class, 'create'])->name('products.create');
            Route::post('/', [ProductController::class, 'store'])->name('products.store');
            Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
            Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
            Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
            Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        });

        // Coupon Management
        Route::resource('coupons', CouponController::class);
        Route::prefix('coupons')->group(function () {
            Route::get('/{coupon}/activate', [CouponController::class, 'activate'])->name('coupons.activate');
            Route::get('/{coupon}/deactivate', [CouponController::class, 'deactivate'])->name('coupons.deactivate');
            Route::get('/{coupon}/edit', [CouponController::class, 'edit'])->name('coupons.edit');
            Route::put('/{coupon}', [CouponController::class, 'update'])->name('coupons.update');
            Route::patch('/{coupon}/toggle-status', [CouponController::class, 'toggleStatus'])->name('coupons.toggle-status');
        });

        // Discount Management
        Route::resource('discounts', DiscountController::class);
        Route::prefix('discounts')->group(function () {
            Route::get('/{discount}/activate', [DiscountController::class, 'activate'])->name('discounts.activate');
            Route::get('/{discount}/deactivate', [DiscountController::class, 'deactivate'])->name('discounts.deactivate');
        });

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });
});

// Authentication Routes
require __DIR__ . '/auth.php';
