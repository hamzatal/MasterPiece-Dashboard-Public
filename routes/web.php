<?php

use App\Http\Controllers\Dashboard\{
    CategoryController,
    CouponController,
    DashboardController,
    DiscountController,
    OrderController,
    ProductController,
    ProfileController,
    ReportController,
    ReviewController,
    UserController,
    ContactController,
    LoginController,
    UserDashboardController,
    BannerController,
};

use App\Http\Controllers\Site\{
    AboutController,
    CartController,
    ContactUsController,
    FaqController,
    HomeController,
    AccountController,
    CheckoutController,
    NotFoundController,
    OrderConfirmationController,
    ProductDetailsController,
    ShopController,
    WishlistController,
    SearchController,
};
use Illuminate\Support\Facades\Route;


//! Test Routes


Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/product-details/{id}', [ProductDetailsController::class, 'show'])->name('product.details');

//! End Test Routes



//? Order Confirmation Routes

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderConfirmationController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderConfirmationController::class, 'show'])->name('order.info');
    Route::get('/my-orders', [OrderConfirmationController::class, 'index'])->name('orders.confirmation');
    Route::get('/order-details/{id}', [OrderConfirmationController::class, 'show'])->name('order.details');
    Route::get('/order-confirmation/{orderId}', [OrderController::class, 'showOrderConfirmation'])->name('order.confirmation');
});

//? Public Routes

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home.index');
Route::get('/about-us', [AboutController::class, 'index']);
Route::get('/404', [NotFoundController::class, 'index']);
Route::get('/contact-us', [ContactUsController::class, 'index']);
Route::post('/contact/store', [ContactUsController::class, 'store'])->name('contact.store');
Route::get('/faq', [FaqController::class, 'index']);
Route::get('/login', [LoginController::class, 'index']);
Route::resource('contacts', ContactController::class);

//? Shop & Product Routes

Route::get('/shop', [ShopController::class, 'index'])->name('shop');

//? Product Frontend Routes

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'frontendIndex'])->name('home.products.index');
    Route::get('/{product:slug}', [ProductController::class, 'frontendShow'])->name('home.product.show');
    Route::get('/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/category/{category:slug}', [ProductController::class, 'productsByCategory'])
        ->name('products.by.category');
});

//? Product Management Routes

Route::prefix('product')->group(function () {
    Route::get('/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product-details/{id}', [ProductDetailsController::class, 'show'])->name('product.details');
});

//? Cart Routes
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
    Route::post('/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');
    Route::delete('/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::delete('/clear', [CartController::class, 'clearCart'])->name('cart.clear');
});

//? Checkout Routes (Authenticated)

Route::middleware(['auth'])->group(function () {
    Route::prefix('checkout')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::post('/store', [CheckoutController::class, 'store'])->name('checkout.store');
    });

    Route::prefix('order')->group(function () {
        Route::get('/success/{order}', [OrderController::class, 'success'])->name('order.success');
        Route::get('/confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');
    });
});

//!Authenticated User Routes

Route::middleware('auth')->group(function () {
    //? Account Management

    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('account.index');
        Route::get('/edit', [AccountController::class, 'edit'])->name('account.edit');
        Route::put('/', [AccountController::class, 'update'])->name('account.update');
    });

    //? Wishlist

    Route::prefix('wishlist')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/add', [WishlistController::class, 'add'])->name('wishlist.add');
        Route::post('/add/{productId}', [WishlistController::class, 'add'])->name('wishlist.add');
        Route::delete('/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
        Route::delete('/', [WishlistController::class, 'clearAll'])->name('wishlist.clearAll');
    });

    //? User Dashboard

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');
        Route::put('/profile/update', [UserDashboardController::class, 'updateProfile'])->name('user.profile.update');
        Route::patch('/cart/{cart}', [UserDashboardController::class, 'updateCartQuantity'])->name('cart.update');
        Route::delete('/cart/{cart}', [UserDashboardController::class, 'removeFromCart'])->name('cart.remove');
    });

    //? Profile

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

//! Admin Routes

Route::middleware(['auth', 'auth.role'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/download-report', [DashboardController::class, 'downloadReport'])->name('dashboard.download-report');

    //? User Management

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/{user}', [UserController::class, 'view'])->name('users.view');
        Route::patch('/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggleActive');
    });

    //? Category Management

    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::post('/categories/{category}/toggle', [CategoryController::class, 'toggle'])->name('categories.toggle');

    //? Product Management

    Route::resource('products', ProductController::class);

    //? Banner Management

    Route::prefix('banners')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('banners.index');
        Route::get('/create', [BannerController::class, 'create'])->name('banners.create');
        Route::post('/', [BannerController::class, 'store'])->name('banners.store');
        Route::get('/{banner}/edit', [BannerController::class, 'edit'])->name('banners.edit');
        Route::put('/{banner}', [BannerController::class, 'update'])->name('banners.update');
        Route::delete('/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy');
        Route::patch('/{banner}/toggle-status', [BannerController::class, 'toggleStatus'])->name('banners.toggleStatus');
    });

    //? Coupon Management

    Route::resource('coupons', CouponController::class);
    Route::prefix('coupons')->group(function () {
        Route::get('/{coupon}/activate', [CouponController::class, 'activate'])->name('coupons.activate');
        Route::get('/{coupon}/deactivate', [CouponController::class, 'deactivate'])->name('coupons.deactivate');
        Route::patch('/{coupon}/toggle-status', [CouponController::class, 'toggleStatus'])->name('coupons.toggle-status');
    });

    //? Discount Management

    Route::prefix('discounts')->group(function () {
        Route::get('/', [DiscountController::class, 'index'])->name('discounts.index');
        Route::get('/create', [DiscountController::class, 'create'])->name('discounts.create');
        Route::post('/', [DiscountController::class, 'store'])->name('discounts.store');
        Route::get('/edit/{discount}', [DiscountController::class, 'edit'])->name('discounts.edit');
        Route::put('/{discount}', [DiscountController::class, 'update'])->name('discounts.update');
        Route::post('/{discount}/toggle-status', [DiscountController::class, 'toggleStatus'])->name('discounts.toggleStatus');
        Route::delete('/{discount}', [DiscountController::class, 'destroy'])->name('discounts.destroy');
        Route::patch('/{discount}/toggle', [DiscountController::class, 'toggle'])->name('discounts.toggle');
    });

    //? Order Management

    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/search', [OrderController::class, 'search'])->name('orders.search');
        Route::get('/export', [OrderController::class, 'export'])->name('orders.export');
        Route::get('/{order}', [OrderController::class, 'view'])->name('orders.view');
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::patch('/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::post('/{order}', [OrderController::class, 'update'])->name('orders.update');
    });

    //? Review Management

    Route::prefix('reviews')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('reviews.index');
        Route::post('/', [ReviewController::class, 'store'])->name('reviews.store');
        Route::get('/{id}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
        Route::post('/{review}/toggle-active', [ReviewController::class, 'toggleActive'])->name('reviews.toggleActive');
        Route::patch('{review}/status', [ReviewController::class, 'updateStatus'])->name('reviews.updateStatus');
    });

    //? Reports

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

require __DIR__ . '/auth.php';
