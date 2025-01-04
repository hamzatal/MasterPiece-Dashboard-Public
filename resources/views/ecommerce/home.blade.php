<x-ecommerce-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('Home') }}
        </h2>
        <link rel="stylesheet" href="css/home.css">
        <link rel="stylesheet" href="css/newproduct.css">
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

    <!-- Start Categories Section -->
    <section class="category-showcase">
        <h4 class="circles-title">Shop By Category</h4>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach($categories as $category)
                <div class="swiper-slide">
                    <a href="{{ route('shop', ['category' => $category->id]) }}" class="category-item">
                        <div class="category-circle">
                            <img
                                src="{{ Storage::url($category->image) }}"
                                alt="{{ $category->name }}"
                                class="category-image"
                                onerror="this.src='/assets/img/categories/default.jpg'">
                        </div>
                        <span class="category-name">{{ $category->name }}</span>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Categories Section -->

    <!-- Start New product section -->
    <section class="sp-section">
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
    </section>
    <!-- End product section -->

    <!-- Start Sale Section -->
    <section class="sale-section">
        <div class="sale-container">
            <h2 class="sale-title">Sale Products</h2>

            <div class="col-xl-9 col-lg-8">
                <div class="shop__product--wrapper">
                    <div class="tab_content">
                        <!-- Grid View -->
                        <div class="sp-container">
                            <div class="sp-grid">
                                @foreach($products as $product)
                                @if($product->is_discount_active)
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
                                        @if($product->discount_percentage)
                                        <span class="sp-tag sp-tag-sale">{{ $product->discount_percentage }}% OFF</span>
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
                                            <span class="sp-old-price">JD {{ number_format($product->original_price, 2) }}</span>
                                            <span class="sp-current-price">JD {{ number_format($product->new_price, 2) }}</span>
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
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
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
                    </div>
                </div>
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

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    @if($coupon)
    <!-- Coupon Popup -->
    <div id="coupon-popup" class="coupon-popup">
        <div class="coupon-popup-content">
            <span class="close-popup">&times;</span>
            <h3>🎉 Special Offer! 🎉</h3>
            <p>Use the code below to get a <strong>{{ $coupon->discount_value }}%</strong> discount:</p>
            <div class="coupon-code">
                <span>{{ $coupon->code }}</span>
            </div>
            <p style="color: red;">Hurry up! Offer ends soon.</p>
        </div>
    </div>
    @endif




</x-ecommerce-app-layout>
