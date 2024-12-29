<x-ecommerce-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shop Right Sidebar') }}
        </h2>
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
                                                            Add to Cart
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
                                    @foreach ($categories as $category)
                                    <li class="widget__categories--menu__list">
                                        <a href="{{ route('shop', ['category' => $category->id]) }}" class="widget__categories--menu__label d-flex align-items-center">
                                            <img class="widget__categories--menu__img" src="{{ Storage::url($category->image) }}" alt="{{$category->name}}">
                                            <span class="widget__categories--menu__text">{{$category->name}}</span>
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
    <style>
        .sp-section {
            padding: 60px 0;
            background-color: #ffffff;
        }

        .sp-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .sp-title {
            text-align: center;
            font-size: 28px;
            margin-bottom: 40px;
            color: #1a1a1a;
            font-weight: 700;
            position: relative;
        }

        .sp-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 3px;
            background: #01206e;
            border-radius: 2px;
        }

        .sp-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .sp-card {
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.25s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .sp-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .sp-image-wrap {
            position: relative;
            padding-top: 100%;
            background: #f5f5f5;
        }

        .sp-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .sp-card:hover .sp-image {
            transform: scale(1.05);
        }

        .sp-tag {
            position: absolute;
            padding: 2px 7px;
            border-radius: 5px;
            font-size: 10px;
            font-weight: 600;
            z-index: 1;
        }

        .sp-tag-sale {
            background: #ef4444;
            color: white;
            top: 10px;
            left: 10px;
        }

        .sp-tag-new {
            background: #10b981;
            color: white;
            top: 10px;
            right: 10px;
        }

        .sp-content {
            padding: 15px;
        }

        .sp-category {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            display: block;
        }

        .sp-name {
            font-size: 14px;
            margin: 0 0 10px;
            line-height: 1.3;
        }

        .sp-name a {
            color: #1a1a1a;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .sp-name a:hover {
            color: #3b82f6;
        }

        .sp-price {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .sp-current-price {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .sp-old-price {
            font-size: 13px;
            color: #9ca3af;
            text-decoration: line-through;
        }

        .sp-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sp-form {
            flex: 1;
        }

        .sp-button {
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .sp-button-cart {
            background: #01206e;
            color: white;
            padding: 8px 12px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .sp-button-cart:hover {
            background: rgb(18, 62, 158);
        }

        .sp-icon-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: #f3f4f6;
            color: #4b5563;
            transition: all 0.2s ease;
        }

        .sp-icon-button:hover {
            background: #01206e;
            color: white;
        }

        .sp-pagination {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        @media (max-width: 768px) {
            .sp-section {
                padding: 40px 0;
            }

            .sp-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 15px;
            }

            .sp-content {
                padding: 12px;
            }

            .sp-name {
                font-size: 13px;
            }

            .sp-current-price {
                font-size: 14px;
            }

            .sp-button-cart {
                padding: 6px 10px;
            }

            .sp-icon-button {
                width: 28px;
                height: 28px;
            }
        }

        .widget__area {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .single__widget {
            padding: 24px;
            margin-bottom: 24px;
            border-bottom: 1px solid #eee;
        }

        .single__widget:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .widget__bg {
            background: #fff;
            border-radius: 8px;
        }

        .widget__title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #f0f0f0;
        }

        .widget__categories--menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .widget__categories--menu__list {
            margin-bottom: 12px;
        }

        .widget__categories--menu__list:last-child {
            margin-bottom: 0;
        }

        .widget__categories--menu__label {
            padding: 10px;
            border-radius: 6px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #444;
        }

        .widget__categories--menu__label:hover {
            background: #f8f9fa;
            transform: translateX(5px);
        }

        .widget__categories--menu__img {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            margin-right: 12px;
            object-fit: cover;
        }

        .widget__categories--menu__text {
            font-size: 15px;
            font-weight: 500;
        }

        .price__filter--form__inner {
            margin-bottom: 20px;
        }

        .price__filter--group {
            flex: 1;
        }

        .price__filter--label {
            display: block;
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }

        .price__filter--input {
            background: #f8f9fa;
            border-radius: 6px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
        }

        .price__filter--currency {
            font-size: 14px;
            color: #666;
            margin-right: 8px;
        }

        .price__filter--input__field {
            border: none;
            background: none;
            width: 100%;
            outline: none;
            font-size: 14px;
            color: #333;
        }

        .price__divider {
            margin: 0 12px;
            color: #666;
        }

        .price__filter--btn {
            width: 100%;
            padding: 1px;
            background: #01206e;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .price__filter--btn:hover {
            background: #0056b3;
        }

        @media (max-width: 991px) {
            .widget__area {
                margin-bottom: 24px;
            }
        }

        .product__view--search__form {
            display: flex;
            align-items: center;
            position: relative;
            background: #f9f9f9;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .product__view--search__input {
            padding: 10px 15px;
            font-size: 14px;
            flex-grow: 1;
            border: none;
            outline: none;
            background: transparent;
        }

        .product__view--search__input::placeholder {
            color: #9ca3af;
            font-style: italic;
        }

        .product__view--search__btn {
            background: #3b82f6;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .product__view--search__btn:hover {
            background: #2563eb;
        }

        .product__view--search__btn svg {
            fill: #ffffff;
        }
    </style>
</x-ecommerce-app-layout>