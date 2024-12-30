<x-ecommerce-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shop Right Sidebar') }}
        </h2>
        <link rel="stylesheet" href="css/shop.css">
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
                            <form class="product__view--search__form" action="{{ route('shop') }}" method="GET">
                                <label class="search__wrapper">
                                    <input
                                        class="product__view--search__input border-0"
                                        placeholder="Search products..."
                                        type="text"
                                        name="search"
                                        value="{{ request('search') }}">
                                </label>
                                <button class="product__view--search__btn" aria-label="shop button" type="submit">
                                    <svg
                                        class="product__view--search__btn--svg"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="22.51"
                                        height="20.443"
                                        viewBox="0 0 512 512">
                                        <path
                                            d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-miterlimit="10"
                                            stroke-width="32" />
                                        <path
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-miterlimit="10"
                                            stroke-width="32"
                                            d="M338.29 338.29L448 448" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Number of Products -->
                    <p class="product__showing--count">
                        Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                    </p>

                    <!-- Clear Filters Button -->
                    @if(request()->has('search') || request()->has('min_price') || request()->has('max_price') || request()->has('category'))
                    <div>
                        <a href="{{ route('shop', ['page' => request('page', 1)]) }}" class="btn btn-clear-filters primary__btn">
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
                                <div id="product_grid" class="tab_pane active show">
                                    <div class="product__section--inner product__grid--inner sp-grid">
                                        @foreach ($products as $product)
                                        <div class="sp-card">
                                            <!-- Image Container -->
                                            <div class="sp-image-wrap">
                                                <a href="{{ route('product.show', $product->id) }}">
                                                    <img class="sp-image" src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
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
                                                <span class="sp-category">{{ $product->category->name }}</span>
                                                <h3 class="sp-name">
                                                    <a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
                                                </h3>

                                                <!-- Price -->
                                                <div class="sp-price">
                                                    <span class="sp-current-price">JD {{ number_format($product->new_price, 2) }}</span>
                                                    @if($product->original_price)
                                                    <span class="sp-old-price">JD {{ number_format($product->original_price, 2) }}</span>
                                                    @endif
                                                </div>

                                                <!-- Actions -->
                                                <div class="sp-actions">
                                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="sp-form">
                                                        @csrf
                                                        <button type="submit" class="sp-button sp-button-cart">
                                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <path d="M9 20a1 1 0 1 0 0 2 1 1 0 0 0 0-2zM19 20a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                                                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17" />
                                                            </svg>
                                                            Add
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="sp-icon-button" title="Add to Wishlist">
                                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('products.show', $product->id) }}" class="sp-icon-button" title="Quick View">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"></path>
                                                            <circle cx="12" cy="12" r="3"></circle>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
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
                                            <span class="widget__categories--menu__text">({{ App\Models\Product::count() }})</span>
                                        </a>
                                    </li>
                                    @foreach ($categories as $category)
                                    <li class="widget__categories--menu__list {{ request('category') == $category->id ? 'active' : '' }}">
                                        <a href="{{ route('shop', ['category' => $category->id]) }}"
                                            class="widget__categories--menu__label d-flex align-items-center">
                                            <img class="widget__categories--menu__img"
                                                src="{{ Storage::url($category->image) }}"
                                                alt="{{$category->name}}">
                                            <span class="widget__categories--menu__text">
                                                {{$category->name}}
                                            </span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
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
