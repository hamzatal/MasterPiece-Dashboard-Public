<x-ecommerce-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('Home') }}
        </h2>
        <link rel="stylesheet" href="css/home.css">
        <link rel="stylesheet" href="css/newproduct.js">
        <link rel="javascript" href="js/home.js">

    </x-slot>

    <!-- Start Banner Slider -->
    <section class="banner-showcase">
        <div class="banner-container">
            <div class="banner-track">
                @foreach($banners as $banner)
                @if($banner->active && $banner->is_homepage === 'hero')
                <div class="banner-slide">
                    <div class="banner-media">
                        <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="banner-image">
                    </div>
                    <div class="banner-overlay">
                        <div class="banner-content">
                            <h2 class="banner-heading">{{ $banner->title }}</h2>
                            <p class="banner-text">{{ $banner->description }}</p>
                            <a href="/shop" class="banner-cta">Explore Now</a>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>

            <div class="banner-controls">
                <button class="banner-arrow banner-prev" aria-label="Previous slide">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>
                <button class="banner-arrow banner-next" aria-label="Next slide">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>
            </div>

            <div class="banner-indicators"></div>
        </div>
    </section>
    <!-- End Banner Slider -->

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
                            <span class="sp-old-price">JD {{ number_format($product->original_price, 2) }}</span>
                            <span class="sp-current-price">JD {{ number_format($product->new_price, 2) }}</span>
                            @else
                            <span class="sp-current-price">JD {{ number_format($product->original_price, 2) }}</span>
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
    </section>
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
    <!-- End Sale Section -->

    <!-- Start banner section -->
    <section class="banner__section section--padding pt-0">
        <div class="container-fluid">
            <div class="row row-cols-md-2 row-cols-1 mb--n28">
                @foreach ($banners as $banner)
                @if ($banner->active && $banner->is_homepage === 'discounted_section')
                <div class="col mb-28">
                    <div class="banner__items position__relative">
                        <a class="banner__items--thumbnail" href="/shop">
                            <!-- Updated image container -->
                            <div class="banner__image-container">
                                <img
                                    class="banner__items--thumbnail__img banner__img--max__height"
                                    src="{{ Storage::url($banner->image) }}"
                                    alt="banner-img">
                            </div>
                            <div class="banner__items--content">
                                <h2 class="banner__items--content__title h3 text-white-custom">{{ $banner->title }}</h2>
                                <span class="banner__items--content__subtitle d-none d-lg-block text-white-custom">{{ $banner->description }}</span>
                                <span class="primary__btn">Shop Now
                                    <svg class="primary__btn--arrow__icon" xmlns="http://www.w3.org/2000/svg" width="20.2" height="12.2" viewBox="0 0 6.2 6.2">
                                        <path d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z" transform="translate(-4 -4)" fill="currentColor"></path>
                                    </svg>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
                @endif
                @endforeach
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

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>


</x-ecommerce-app-layout>