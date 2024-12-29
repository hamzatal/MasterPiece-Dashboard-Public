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
    ProductDetailsController,
    ProductGalleryController,
    ProductLeftSidebarController,
    ShopController,
    WishlistController
};
use Illuminate\Support\Facades\Route;



//!TEST



//!END TEST


Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');


//? Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

//? Checkout Routes
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/place-order', [OrderController::class, 'store'])->name('place.order');

//? Banners Routes
Route::middleware(['auth'])->prefix('banners')->group(function () {
    Route::get('/', [BannerController::class, 'index'])->name('banners.index'); // List all banners
    Route::get('/create', [BannerController::class, 'create'])->name('banners.create'); // Show form to create a banner
    Route::post('/', [BannerController::class, 'store'])->name('banners.store'); // Store new banner
    Route::get('/{banner}/edit', [BannerController::class, 'edit'])->name('banners.edit'); // Show form to edit a banner
    Route::put('/{banner}', [BannerController::class, 'update'])->name('banners.update'); // Update an existing banner
    Route::delete('/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy'); // Delete a banner
    Route::patch('/banners/{banner}/toggle-status', [BannerController::class, 'toggleStatus'])->name('banners.toggleStatus');
});

//? Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::post('/cart/add/{product}', [ShopController::class, 'addToCart'])->name('cart.add');


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

//? Shop Routes
Route::get('/product-details', [ProductDetailsController::class, 'index']);
Route::get('/product-gallery', [ProductGalleryController::class, 'index']);
Route::get('/product-left-sidebar', [ProductLeftSidebarController::class, 'index']);

//? Product Routes
Route::group(['prefix' => 'products'], function () {
    Route::get('/', [ProductController::class, 'frontendIndex'])->name('home.products.index');
    Route::get('/{product:slug}', [ProductController::class, 'frontendShow'])->name('home.product.show');
    Route::get('/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/category/{category:slug}', [ProductController::class, 'productsByCategory'])
        ->name('products.by.category');
});

//? product Routes
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/product', [ProductController::class, 'store'])->name('product.store');


//? Authentication Required Routes
Route::middleware('auth')->group(function () {
    // Account Management
    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('account.index');
        Route::get('/edit', [AccountController::class, 'edit'])->name('account.edit');
        Route::put('/', [AccountController::class, 'update'])->name('account.update');
    });

    //? Wishlist
    Route::middleware(['auth'])->group(function () {
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
        Route::delete('/wishlist/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
        Route::delete('/wishlist', [WishlistController::class, 'clearAll'])->name('wishlist.clearAll');
    });

    Route::post('/wishlist/add/{productId}', [WishlistController::class, 'add'])->name('wishlist.add');

    //? User Dashboard
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');
        Route::put('/profile/update', [UserDashboardController::class, 'updateProfile'])->name('user.profile.update');
        Route::patch('/cart/{cart}', [UserDashboardController::class, 'updateCartQuantity'])->name('cart.update');
        Route::delete('/cart/{cart}', [UserDashboardController::class, 'removeFromCart'])->name('cart.remove');
    });
});

//? Admin Routes
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

//? Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
