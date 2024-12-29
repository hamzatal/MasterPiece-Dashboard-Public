<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Wishlist;
use App\View\Components\AdminAppLayout;
use App\View\Components\EcommerceAppLayout;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Blade::component('admin-app-layout', AdminAppLayout::class);
        Blade::component('ecommerce-app-layout', EcommerceAppLayout::class);

        View::composer('*', function ($view) {
            $wishlistCount = Auth::check() ? Wishlist::where('user_id', Auth::id())->count() : 0;

            $view->with('wishlistCount', $wishlistCount);
        });
    }
}
