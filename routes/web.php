<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
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
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\NotFoundController;
use App\Http\Controllers\ProductDetailsController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\ProductLeftSidebarController;
use App\Http\Controllers\ShopRightSidebarController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|----------------------------------------------------------------------
| Ecommerce Routes
|----------------------------------------------------------------------
*/

Route::get('/about-us', [AboutController::class, 'index']);
Route::get('/cart', [CartController::class, 'index']);
Route::get('/404', [NotFoundController::class, 'index']);
Route::get('/checkout', [CheckoutController::class, 'index']);
Route::get('/contact-us', [ContactUsController::class, 'index']);
Route::get('/my-account', [MyAccountController::class, 'index']);
Route::get('/product-details', [ProductDetailsController::class, 'index']);
Route::get('/product-gallery', [ProductGalleryController::class, 'index']);
Route::get('/product-left-sidebar', [ProductLeftSidebarController::class, 'index']);
Route::get('/shop-right-sidebar', [ShopRightSidebarController::class, 'index']);
Route::get('/wishlist', [WishlistController::class, 'index']);
Route::get('/faq', [FaqController::class, 'index']);
Route::get('/login', [LoginController::class, 'index']);

/*
|----------------------------------------------------------------------
| Ecommerce Routes
|----------------------------------------------------------------------
*/

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
Route::post('categories/{category}/toggle', [CategoryController::class, 'toggle'])->name('categories.toggle');

/*
|----------------------------------------------------------------------
| Ecommerce Routes
|----------------------------------------------------------------------
*/

Route::group(['prefix' => 'products'], function () {
    // Frontend product listing
    Route::get('/', [ProductController::class, 'frontendIndex'])->name('home.products.index');

    // Frontend product detail
    Route::get('/{product:slug}', [ProductController::class, 'frontendShow'])->name('home.product.show');

    // Product search
    Route::get('/search', [ProductController::class, 'search'])->name('products.search');

    // Category-based product filtering
    Route::get('/category/{category:slug}', [ProductController::class, 'productsByCategory'])
        ->name('products.by.category');
});




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
        Route::post('/{order}', [OrderController::class, 'update'])->name('orders.update');
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

        // Discount Routes
        Route::prefix('discounts')->group(function () {
            Route::get('/', [DiscountController::class, 'index'])->name('discounts.index'); // View all reviews
            Route::get('/create', [DiscountController::class, 'create'])->name('discounts.create'); // Add brands
            Route::get('/edit/{discount}', [DiscountController::class, 'edit'])->name('discounts.edit'); // Edit brands
            Route::post('/', [DiscountController::class, 'store'])->name('discounts.store'); // Create brands
            Route::put('/{discount}', [DiscountController::class, 'update'])->name('discounts.update'); // Update brands
            Route::post('/{discount}/toggle-status', [DiscountController::class, 'toggleStatus'])->name('discounts.toggleStatus');
            Route::delete('/{discount}', [DiscountController::class, 'destroy'])->name('discounts.destroy'); // Delete brands
        });

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });
});

// Authentication Routes
require __DIR__ . '/auth.php';
