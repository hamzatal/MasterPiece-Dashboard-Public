<x-ecommerce-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('Home') }}
        </h2>
    </x-slot>

    <!-- Start Video Banner Section -->
    <section class="hero__video--section">
        <div class="hero__video--inner">
            <video autoplay muted loop playsinline class="hero__video--banner">
                <source src="assets/videos/Hero.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="hero__video--content">
                <div class="container-fluid">
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Video Banner Section -->


    <!-- Start banner section -->
    <section class="banner__section section--padding">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="banner__section--inner position__relative">
                        <a class="banner__items--thumbnail display-block" href="/shop"><img class="banner__items--thumbnail__img banner__img--height__md display-block" src="assets/img/banner/banner-bg1212.jpg" alt="banner-img">
                            <div class="banner__content--style2">
                                <h2 class="banner__content--style2__title text-white">Hello World !</h2>
                                <p class="banner__content--style2__desc">Elevate your look with clothing designed specifically for programmers who value refined taste and professionalism in every detail.</p>

                                <span class="primary__btn">Shop Now
                                    <svg class="primary__btn--arrow__icon" xmlns="http://www.w3.org/2000/svg" width="20.2" height="12.2" viewBox="0 0 6.2 6.2">
                                        <path d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z" transform="translate(-4 -4)" fill="currentColor"></path>
                                    </svg>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- End banner section -->

    <!-- Start New product section -->
    <section class="sp-section">
        <div class="sp-container">
            <h2 class="sp-title">New Products</h2>

            <div class="sp-grid">
                @foreach($products as $product)
                <div class="sp-card">
                    <!-- Image Container -->
                    <div class="sp-image-wrap">
                        <a href="{{ route('products.show', $product->id) }}">
                            @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="sp-image">
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
                            <span class="sp-current-price">${{ number_format($product->new_price, 2) }}</span>
                            <span class="sp-old-price">${{ number_format($product->original_price, 2) }}</span>
                            @else
                            <span class="sp-current-price">${{ number_format($product->original_price, 2) }}</span>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="sp-actions">
                            <form action="{{ route('cart.add') }}" method="POST" class="sp-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="sp-button sp-button-cart">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 20a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"></path>
                                        <path d="M20 20a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"></path>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                    </svg>
                                    Add
                                </button>
                            </form>
                            <a href="{{ route('wishlist.add', $product->id) }}" class="sp-icon-button" title="Add to Wishlist">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </a>
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

            <!-- Pagination -->
            <div class="sp-pagination">
                @if($products->hasPages())
                {{ $products->links() }}
                @else
                <p>No products to display.</p>
                @endif
            </div>
        </div>
    </section>

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
            background: #3b82f6;
            border-radius: 2px;
        }

        .sp-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
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
    </style>
    <!-- End product section -->

    <!-- Start Sale Section -->
    <section class="sale-section">
        <div class="sale-container">
            <h2 class="sale-title">Sale Products</h2>

            <div class="sale-grid">
                @foreach($products as $product)
                @if($product->is_discount_active)
                <div class="sale-card">
                    <!-- Image Container -->
                    <div class="sale-image-wrap">
                        <a href="{{ route('products.show', $product->id) }}">
                            @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="sale-image">
                            @else
                            <img src="assets/img/product/default.png" alt="default-product-image" class="sale-image">
                            @endif
                        </a>
                        @if($product->original_price && $product->price < $product->original_price)
                            <span class="sale-tag sale-tag-sale">{{ $product->discount_percentage }}% OFF</span>
                            @endif
                    </div>

                    <!-- Content -->
                    <div class="sale-content">
                        <span class="sale-category">{{ $product->category->name }}</span>
                        <h3 class="sale-name">
                            <a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                        </h3>

                        <div class="sale-price">
                            <span class="sale-current-price">${{ number_format($product->new_price, 2) }}</span>
                            @if($product->original_price)
                            <span class="sale-old-price">${{ number_format($product->original_price, 2) }}</span>
                            @endif
                        </div>

                        <div class="sale-actions">
                            <form action="{{ route('cart.add') }}" method="POST" class="sale-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="sale-button sale-button-cart">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 20a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"></path>
                                        <path d="M20 20a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"></path>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                    </svg>
                                    Add
                                </button>
                            </form>
                            <a href="{{ route('wishlist.add', $product->id) }}" class="sale-icon-button" title="Add to Wishlist">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('products.show', $product->id) }}" class="sale-icon-button" title="Quick View">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>

            <div class="sale-pagination">
                {{ $products->links() }}
            </div>
        </div>
    </section>

    <style>
        .sale-section {
            padding: 60px 0;
            background-color: #ffffff;
        }

        .sale-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .sale-title {
            text-align: center;
            font-size: 28px;
            margin-bottom: 40px;
            color: #1a1a1a;
            font-weight: 700;
            position: relative;
        }

        .sale-title::after {
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

        .sale-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .sale-card {
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.25s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .sale-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .sale-image-wrap {
            position: relative;
            padding-top: 100%;
            background: #f5f5f5;
        }

        .sale-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .sale-card:hover .sale-image {
            transform: scale(1.05);
        }

        .sale-tag {
            position: absolute;
            padding: 2px 7px;
            border-radius: 5px;
            font-size: 10px;
            font-weight: 600;
            z-index: 1;
        }

        .sale-tag-sale {
            background: #ef4444;
            color: white;
            top: 10px;
            left: 10px;
        }

        .sale-content {
            padding: 15px;
        }

        .sale-category {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            display: block;
        }

        .sale-name {
            font-size: 14px;
            margin: 0 0 10px;
            line-height: 1.3;
        }

        .sale-name a {
            color: #1a1a1a;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .sale-name a:hover {
            color: #01206e;
        }

        .sale-price {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .sale-current-price {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .sale-old-price {
            font-size: 13px;
            color: #9ca3af;
            text-decoration: line-through;
        }

        .sale-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sale-form {
            flex: 1;
        }

        .sale-button {
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .sale-button-cart {
            background: #01206e;
            color: white;
            padding: 8px 12px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .sale-button-cart:hover {
            background: rgb(18, 66, 170);
        }

        .sale-icon-button {
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

        .sale-icon-button:hover {
            background: #01206e;
            color: white;
        }

        .sale-pagination {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        @media (max-width: 768px) {
            .sale-section {
                padding: 40px 0;
            }

            .sale-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 15px;
            }

            .sale-content {
                padding: 12px;
            }

            .sale-name {
                font-size: 13px;
            }

            .sale-current-price {
                font-size: 14px;
            }

            .sale-button-cart {
                padding: 6px 10px;
            }

            .sale-icon-button {
                width: 28px;
                height: 28px;
            }
        }
    </style>
    <!-- End Sale Section -->
    <!-- Start banner section -->
    <section class="banner__section section--padding pt-0">
        <div class="container-fluid">
            <div class="row row-cols-md-2 row-cols-1 mb--n28">
                <div class="col mb-28">
                    <div class="banner__items position__relative">
                        <a class="banner__items--thumbnail " href="/shop"><img class="banner__items--thumbnail__img banner__img--max__height" src="assets/img/banner/banner5.png" alt="banner-img">
                            <div class="banner__items--content">
                                <span class="banner__items--content__subtitle d-none d-lg-block">Pick Your Items</span>
                                <h2 class="banner__items--content__title h3">Up to 25% Off Order Now</h2>
                                <span class="banner__items--content__link"><u>Shop now</u></span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col mb-28">
                    <div class="banner__items position__relative">
                        <a class="banner__items--thumbnail " href="/shop"><img class="banner__items--thumbnail__img banner__img--max__height" src="assets/img/banner/banner6.png" alt="banner-img">
                            <div class="banner__items--content">
                                <span class="banner__items--content__subtitle d-none d-lg-block">Special offer</span>
                                <h2 class="banner__items--content__title h3">Up to 35% Off Order Now</h2>
                                <span class="banner__items--content__link"><u>Discover Now</u> </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End banner section -->

    <!-- Start testimonial section -->
    <section class="testimonial__section section--padding pt-0">
        <div class="container-fluid">
            <div class="section__heading text-center mb-40">
                <h2 class="section__heading--maintitle">Our Clients Say</h2>
            </div>
            <div class="testimonial__section--inner testimonial__swiper--activation swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="testimonial__items text-center">
                            <div class="testimonial__items--thumbnail">
                                <img class="testimonial__items--thumbnail__img border-radius-50" src="assets/img/other/testimonial-thumb1.png" alt="testimonial-img">
                            </div>
                            <div class="testimonial__items--content">
                                <h3 class="testimonial__items--title">Nike Mardson</h3>
                                <span class="testimonial__items--subtitle">fashion</span>
                                <p class="testimonial__items--desc">Lorem ipsum dolor sit amet, consectetur adipisicin elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim </p>
                                <ul class="rating testimonial__rating d-flex justify-content-center">
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testimonial__items text-center">
                            <div class="testimonial__items--thumbnail">
                                <img class="testimonial__items--thumbnail__img border-radius-50" src="assets/img/other/testimonial-thumb2.png" alt="testimonial-img">
                            </div>
                            <div class="testimonial__items--content">
                                <h3 class="testimonial__items--title">Laura Johnson</h3>
                                <span class="testimonial__items--subtitle">fashion</span>
                                <p class="testimonial__items--desc">Lorem ipsum dolor sit amet, consectetur adipisicin elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim </p>
                                <ul class="rating testimonial__rating d-flex justify-content-center">
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testimonial__items text-center">
                            <div class="testimonial__items--thumbnail">
                                <img class="testimonial__items--thumbnail__img border-radius-50" src="assets/img/other/testimonial-thumb3.png" alt="testimonial-img">
                            </div>
                            <div class="testimonial__items--content">
                                <h3 class="testimonial__items--title">Richard Smith</h3>
                                <span class="testimonial__items--subtitle">fashion</span>
                                <p class="testimonial__items--desc">Lorem ipsum dolor sit amet, consectetur adipisicin elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim </p>
                                <ul class="rating testimonial__rating d-flex justify-content-center">
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testimonial__items text-center">
                            <div class="testimonial__items--thumbnail">
                                <img class="testimonial__items--thumbnail__img border-radius-50" src="assets/img/other/testimonial-thumb1.png" alt="testimonial-img">
                            </div>
                            <div class="testimonial__items--content">
                                <h3 class="testimonial__items--title">Nike Mardson</h3>
                                <span class="testimonial__items--subtitle">fashion</span>
                                <p class="testimonial__items--desc">Lorem ipsum dolor sit amet, consectetur adipisicin elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim </p>
                                <ul class="rating testimonial__rating d-flex justify-content-center">
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial__pagination swiper-pagination"></div>
            </div>
        </div>
    </section>
    <!-- End testimonial section -->

    <!-- Start banner section -->
    <!-- <section class="banner__section section--padding pt-0">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="banner__section--inner position__relative">
                        <a class="banner__items--thumbnail display-block" href="/shop-right-sidebar"><img class="banner__items--thumbnail__img banner__img--height__md display-block" src="assets/img/banner/banner-bg2.png" alt="banner-img">
                            <div class="banner__content--style2">
                                <h2 class="banner__content--style2__title text-white">Need Winter Boots? </h2>
                                <p class="banner__content--style2__desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua enim ad minim veniam, quis nostrud exercitation </p>
                                <span class="primary__btn">Shop Now
                                    <svg class="primary__btn--arrow__icon" xmlns="http://www.w3.org/2000/svg" width="20.2" height="12.2" viewBox="0 0 6.2 6.2">
                                        <path d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z" transform="translate(-4 -4)" fill="currentColor"></path>
                                    </svg>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- End banner section -->


</x-ecommerce-app-layout>