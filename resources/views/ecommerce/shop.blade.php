<x-ecommerce-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shop Right Sidebar') }}
        </h2>
        <link rel="stylesheet" href="css/shop.css">
        <link rel="javascript" href="js/shop.js">
    </x-slot>

    <main class="main__content_wrapper">

        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Shop</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Shop</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- Start shop section -->
        <section class="shop__section section--padding sp-section">
            <div class="container-fluid sp-container">
                <!-- Shop Header Start -->
                <div class="shop__header bg__gray--color d-flex align-items-center justify-content-between mb-30">
                    <!-- Product View Mode -->
                    <div class="product__view--mode d-flex align-items-center">
                        <!-- Search -->
                        <div class="product__view--mode__list product__view--search d-none d-lg-block">
                            <label class="search__wrapper position-relative" style="display: flex; align-items: center; background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 30px; padding: 0.5rem 1rem; width: 100%; max-width: 400px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16" style="margin-left: 15px; color: #666;">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                                <input
                                    id="searchInput"
                                    class="product__view--search__input"
                                    style="border: none; outline: none; background: none; width: 100%; font-size: 16px; color: #333;"
                                    placeholder="Search products..."
                                    type="text"
                                    name="search"
                                    autocomplete="off">
                            </label>
                        </div>
                        <div id="searchResults" class="search-results" style="position: absolute; background: #fff; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); margin-top: 0.5rem; width: 100%; max-width: 400px; display: none; z-index: 10; max-height: 300px; overflow-y: auto;"></div>

                    </div>

                    <!-- Number of Products -->
                    <p class="product__showing--count">
                        Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                    </p>

                    <!-- Clear Filters Button -->
                    @if(request()->has('search') || request()->has('min_price') || request()->has('max_price') || request()->has('category'))
                    <div>
                        <a href="{{ route('shop', ['page' => request('page', 1)]) }}" style="background-color: red;" class="btn btn-clear-filters primary__btn">
                            Clear All Filters
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Main Content Area -->
                <div class="row">
                    <!-- Product Grid -->
                    <div class="col-xl-9 col-lg-8">
                        <div class="shop__product--wrapper">
                            <div class="tab_content">
                                <!-- Grid View -->
                                <div class="sp-container">
                                    <div class="sp-grid">
                                        @foreach($products as $product)
                                        <div class="sp-card">
                                            <!-- Image Container -->
                                            <div class="sp-image-wrap">
                                                <a href="{{ route('product.details', $product->id) }}">
                                                    @if($product->image1)
                                                    <img src="{{ Storage::url($product->image1) }}" alt="{{ $product->name }}" class="sp-image">
                                                    @else
                                                    <img src="assets/img/product/default.png" alt="default-product-image" class="sp-image">
                                                    @endif
                                                </a>
                                                @if($product->is_discount_active && $product->discount_percentage)
                                                <span class="sp-tag sp-tag-sale">{{ $product->discount_percentage }}% OFF</span>
                                                @endif
                                                @if(now()->diffInDays($product->created_at) <= 30)
                                                    <span class="sp-tag sp-tag-new">NEW</span>
                                                    @endif
                                            </div>

                                            <!-- Content -->
                                            <div class="sp-content">
                                                <span class="sp-category">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                                <h3 class="sp-name">
                                                    <a href="{{ route('products.show', $product->id) }}">{{ htmlspecialchars($product->name) }}</a>
                                                </h3>

                                                <!-- Price -->
                                                <div class="sp-price">
                                                    @if ($product->is_discount_active)
                                                    <span class="sp-old-price">JD {{ number_format($product->original_price, 2) }}</span>
                                                    <span class="sp-current-price">JD {{ number_format($product->new_price, 2) }}</span>
                                                    @else
                                                    <span class="sp-current-price">JD {{ number_format($product->original_price, 2) }}</span>
                                                    @endif
                                                </div>
                                                <!-- Actions -->
                                                <div class="action-group">
                                                    <form action="{{ route('cart.add') }}" method="POST" class="action-form">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <button type="submit" class="action-button cart-button">
                                                            <span class="button-content">
                                                                <svg class="button-icon" viewBox="0 0 24 24" width="18" height="18">
                                                                    <path d="M9 20a1 1 0 1 0 0 2 1 1 0 0 0 0-2zM19 20a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                                                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17" />
                                                                </svg>
                                                                <span class="button-text">Add to Cart</span>
                                                            </span>
                                                            <span class="button-feedback">
                                                                <svg class="check-icon" viewBox="0 0 24 24" width="18" height="18">
                                                                    <path d="M20 6L9 17l-5-5" />
                                                                </svg>
                                                            </span>
                                                        </button>
                                                    </form>

                                                    <div class="action-controls">
                                                        @php
                                                        $isInWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                                                        @endphp

                                                        <form action="{{ route('wishlist.add', $product->id) }}" method="POST" class="action-form">
                                                            @csrf
                                                            <button type="submit" class="icon-button wishlist-button" title="Add to Wishlist">
                                                                <svg class="heart-icon {{ $isInWishlist ? 'heart-added' : '' }}" viewBox="0 0 24 24" width="20" height="20">
                                                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                                                </svg>
                                                                <span class="tooltip">{{ $isInWishlist ? 'In Wishlist' : 'Add to Wishlist' }}</span>
                                                            </button>
                                                        </form>


                                                        <a href="{{ route('product.details', $product->id) }}" class="icon-button details-button" title="View Details">
                                                            <svg class="details-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                                                <path d="M12 2a10 10 0 1010 10A10 10 0 0012 2zm0 18a8 8 0 118-8 8 8 0 01-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" />
                                                            </svg>

                                                            <span class="tooltip">View Details</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- Pagination -->
                                    <div class="sp-pagination">
                                        @if($products->count() > 0)
                                        @if($products->hasPages())
                                        {{ $products->links() }}
                                        @endif
                                        @else
                                        <p>No products to display.</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Pagination -->
                                <div class="pagination__area bg__gray--color">
                                    <nav class="pagination justify-content-center">
                                        {{ $products->links() }}
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-xl-3 col-lg-4">
                        <div class="shop__sidebar--widget widget__area d-none d-lg-block">
                            <!-- Categories Widget -->
                            <div class="single__widget widget__bg">
                                <h2 class="widget__title h3">Categories</h2>
                                <ul class="widget__categories--menu">
                                    <li class="widget__categories--menu__list {{ !request('category') ? 'active' : '' }}">
                                        <a href="{{ route('shop') }}" class="widget__categories--menu__label">
                                            All Categories
                                            <span class="widget__categories--menu__text">({{ App\Models\Category::count() }})</span>
                                        </a>
                                    </li>
                                    @foreach ($categories as $category)
                                    <li class="widget__categories--menu__list {{ request('category') == $category->id ? 'active' : '' }}">
                                        <a href="{{ route('shop', ['category' => $category->id]) }}"
                                            class="widget__categories--menu__label d-flex align-items-center">
                                            <img class="widget__categories--menu__img"
                                                src="{{ Storage::url($category->image) }}"
                                                alt="{{ $category->name }}">
                                            <span class="widget__categories--menu__text">
                                                {{ $category->name }}
                                            </span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                <!-- Pagination for Categories -->
                                <div class="widget__pagination">
                                    {{ $categories->links() }}
                                </div>

                            </div>

                            <!-- Price Filter Widget -->
                            <div class="single__widget price__filter widget__bg">
                                <h2 class="widget__title h3">Filter By Price</h2>
                                <form class="price__filter--form" action="{{ route('shop') }}" method="GET">
                                    <div class="price__filter--form__inner mb-15 d-flex align-items-center">
                                        <div class="price__filter--group">
                                            <label class="price__filter--label">From</label>
                                            <div class="price__filter--input">
                                                <span class="price__filter--currency">JD</span>
                                                <input name="min_price" type="number" class="price__filter--input__field" value="{{ request('min_price') }}" min="0">
                                            </div>
                                        </div>
                                        <div class="price__divider">
                                            <span>-</span>
                                        </div>
                                        <div class="price__filter--group">
                                            <label class="price__filter--label">To</label>
                                            <div class="price__filter--input">
                                                <span class="price__filter--currency">JD</span>
                                                <input name="max_price" type="number" class="price__filter--input__field" value="{{ request('max_price') }}" min="0">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="price__filter--btn primary__btn" type="submit">Filter</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- End shop section -->

    </main>

</x-ecommerce-app-layout>
