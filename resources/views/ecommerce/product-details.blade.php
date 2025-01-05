<x-ecommerce-app-layout>
    <x-slot name="header">
        <h2 class="page-title">{{ ('Product Details') }}</h2>
        <link rel="stylesheet" href="css/product-details.css">
        <link rel="javascript" href="js/product-details.js">
    </x-slot>
    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">Product Details</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">Product Details</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- Main Product Section -->
    <main class="product">
        <div class="product__container">
            <!-- Product Grid -->
            <div class="product__grid">
                <!-- Product Gallery -->
                <div class="product__gallery">
                    <div class="gallery__main">
                        <button class="gallery__nav gallery__nav--prev" id="prevImage">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="gallery__container" id="mainGallery">
                            @if($product->image1)
                            <img src="{{ asset('storage/' . $product->image1) }}" alt="{{ $product->name }}" class="gallery__image gallery__image--active">
                            @endif
                            @if($product->image2)
                            <img src="{{ asset('storage/' . $product->image2) }}" alt="{{ $product->name }}" class="gallery__image">
                            @endif
                            @if($product->image3)
                            <img src="{{ asset('storage/' . $product->image3) }}" alt="{{ $product->name }}" class="gallery__image">
                            @endif
                        </div>
                        <button class="gallery__nav gallery__nav--next" id="nextImage">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="gallery__thumbnails" id="galleryThumbs"></div>
                </div>

                <!-- Product Info -->
                <div class="product__info">
                    <h1 class="product__title">{{ $product->name }}</h1>
                    <div class="product__meta">
                        <span class="product__category">{{ $product->category->name ?? 'N/A' }}</span>
                        @if($product->rating)
                       
                        @endif
                    </div>

                    <div class="sp-price">
                        @if ($product->is_discount_active)
                        <span class="sp-old-price">JD {{ number_format($product->original_price, 2) }}</span>
                        <span class="sp-current-price">JD {{ number_format($product->new_price, 2) }}</span>
                        <span class="sp-discount-message">({{ $product->discount_percentage }}% OFF)</span>
                        @else
                        <span class="sp-current-price">JD {{ number_format($product->original_price, 2) }}</span>
                        @endif
                    </div>
                    <form action="{{ route('cart.add') }}" method="POST" class="product__form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        @if($product->color)
                        <div class="form__group">
                            <h3 class="form__label">Select Color</h3>
                            <div class="form__options">
                                @foreach(explode(',', $product->color) as $color)
                                <label class="form__option">
                                    <input type="radio" name="color" value="{{ trim($color) }}" {{ $loop->first ? 'checked' : '' }}>
                                    <span class="option__label">{{ trim($color) }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($product->size)
                        <div class="form__group">
                            <h3 class="form__label">Select Size</h3>
                            <div class="form__options">
                                @foreach(explode(',', $product->size) as $size)
                                <label class="form__option">
                                    <input type="radio" name="size" value="{{ trim($size) }}" {{ $loop->first ? 'checked' : '' }}>
                                    <span class="option__label">{{ trim($size) }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="form__group">
                            <h3 class="form__label">Quantity</h3>
                            <div class="quantity">
                                <button type="button" class="quantity__btn quantity__btn--minus" id="decreaseQuantity">-</button>
                                <input type="number" name="quantity" id="quantityInput" value="1" min="1" max="{{ $product->stock_quantity }}" class="quantity__input">
                                <button type="button" class="quantity__btn quantity__btn--plus" id="increaseQuantity">+</button>
                            </div>
                        </div>

                        <div class="form__actions">
                            <button type="submit" class="btn btn--primary">Add to Cart</button>
                            <button type="button" class="btn btn--secondary" data-product="{{ $product->id }}">
                                <i class="far fa-heart"></i>
                                <span>Add to Wishlist</span>
                            </button>
                        </div>
                    </form>
                    <div>
                        <!-- Product Description -->
                        <h4 style="margin-top: 20px;" class="description__title">Product Description</h4>
                        <div class="description__content">
                            {{ $product->description }}
                        </div>
                    </div>
                </div>
            </div>

                <div class="reviews__header">
                    <h2 class="reviews__title">Customer Reviews</h2>
                    <button class="btn btn--primary" id="writeReviewBtn">Write a Review</button>
                </div>

                <div class="reviews__content">
                    <div class="reviews__list" id="reviewsList">
                    </div>

                    <form id="reviewForm" action="{{ route('reviews.store') }}" method="POST" style="display: none;">
                        @csrf
                        <h3 class="form__title">Write Your Review</h3>
                        <div class="form__group">
                            <label>Your Rating:</label>
                            <div class="rating__input">
                                @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required>
                                <label for="star{{ $i }}">
                                    <i class="fas fa-star"></i>
                                </label>
                                @endfor
                            </div>
                        </div>
                        <div class="form__group">
                            <textarea name="comment" placeholder="Your review" required></textarea>
                        </div>
                        <div class="form__row">
                            <div class="form__group">
                                <input type="text" name="name" placeholder="Your name" required>
                            </div>
                            <div class="form__group">
                                <input type="email" name="email" placeholder="Your email" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn--primary">Submit Review</button>
                    </form>
                </div>
            </section> -->


        </div>
    </main>
</x-ecommerce-app-layout>
