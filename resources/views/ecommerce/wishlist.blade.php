<x-ecommerce-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Wishlist') }}
        </h2>
        <link rel="stylesheet" href="{{ asset('css/wishlist.css') }}">
        <link rel="stylesheet" href="{{ asset('css/newproduct.css') }}">

    </x-slot>

    <main class="main__content_wrapper">
        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Wishlist</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Wishlist</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- Start Wishlist Page -->
        <section class="favorites-showcase">
            <div class="favorites-container">
                <div class="favorites-wrapper">
                    @if(session('success'))
                    <div class="alert-box alert-box--success">
                        {{ session('success') }}
                        <button type="button" class="alert-box__close" data-bs-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert-box alert-box--error">
                        {{ session('error') }}
                        <button type="button" class="alert-box__close" data-bs-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if($wishlistItems->count() > 0)
                    <div class="favorites-grid">
                        @foreach($wishlistItems as $item)
                        <div class="product-card" data-item-id="{{ $item->id }}">
                            <div class="product-card__image">
                                <img src="{{ Storage::url($item->product->image1) }}" alt="{{ $item->product->name }}">
                                @if($item->product->original_price && $item->product->original_price > $item->product->new_price)
                                <span class="product-card__badge">Sale</span>
                                @endif
                            </div>

                            <div class="product-card__content">
                                <h3 class="product-card__title">{{ $item->product->name }}</h3>
                                <p class="product-card__description">{{ $item->product->category->name }}</p>

                                <div class="product-card__status">
                                    @if($item->product->stock_quantity > 0)
                                    <span class="status-indicator status-indicator--in-stock">In Stock</span>
                                    @else
                                    <span class="status-indicator status-indicator--out-stock">Out of Stock</span>
                                    @endif
                                </div>

                                <div class="product-card__price">
                                    @if($item->product->original_price && $item->product->original_price > $item->product->new_price)
                                    <span class="price-original">JD {{ number_format($item->product->original_price, 2) }}</span>
                                    <span class="price-current">JD {{ number_format($item->product->new_price, 2) }}</span>
                                    @else
                                    <span class="price-current">JD {{ number_format($item->product->new_price, 2) }}</span>
                                    @endif
                                </div>

                                <div class="product-card__actions">
                                    @if($item->product->stock_quantity > 0)
                                    <form action="{{ route('cart.add') }}" method="POST" class="action-form">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
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
                                    @endif

                                    <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="action-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-action--remove">
                                            <i class="fas fa-trash-alt"></i>
                                            <span>Remove</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div id="confirmation-dialog" class="confirmation-dialog" style="display: none;">
                        <div class="confirmation-content">
                            <div class="confirmation-message">
                                Are you sure you want to clear your wishlist?
                            </div>
                            <div class="confirmation-buttons">
                                <button id="confirm-btn" class="confirm-btn">Confirm</button>
                                <button id="cancel-btn" class="cancel-btn">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <div class="favorites-footer">
                        <div class="favorites-footer__actions">
                            <form action="{{ route('wishlist.clearAll') }}" method="POST" id="clear-wishlist-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" id="clear-wishlist-btn" class="btn-secondary">
                                    <i class="fas fa-trash"></i>
                                    <span>Clear Wishlist</span>
                                </button>
                            </form>

                            <a href="{{ route('products.index') }}" class="btn-primary">
                                <i class="fas fa-shopping-bag"></i>
                                <span>Continue Shopping</span>
                            </a>
                        </div>

                        @if($wishlistItems->hasPages())
                        <div class="pagination">
                            {{ $wishlistItems->onEachSide(1)->links() }}
                        </div>
                        @endif
                    </div>

                    @else
                    <div class="favorites-empty">
                        <i class="fas fa-heart"></i>
                        <h3>Your wishlist is empty</h3>
                        <p>Browse our products and add some items to your wishlist!</p>
                        <a href="/shop" class="empty-btn-primary">
                            <i class="fas fa-shopping-bag"></i>
                            <span>Browse Products</span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        <!-- End Wishlist Page -->

    <!-- Start Sale Section -->
    <section class="sale-section">
        <div class="sale-container">
            <h2 class="sale-title">Sale Products</h2>
            <div class="sp-wrapper">
                <div class="sp-grid">
                    @foreach($products->where('is_discount_active', true)->chunk(5) as $chunk)
                    @foreach($chunk as $product)
                    <div class="sp-card">
                        <div class="sp-image-wrap">
                            <a href="{{ route('product.details', $product->id) }}">
                                <img src="{{ $product->image1 ? Storage::url($product->image1) : 'assets/img/product/default.png' }}"
                                    alt="{{ $product->name }}"
                                    class="sp-image">
                            </a>
                            @if($product->discount_percentage)
                            <span class="sp-tag sp-tag-sale ">{{ $product->discount_percentage }}% OFF</span>
                            @endif
                        </div>

                        <div class="sp-content">
                            <span class="sp-category">{{ $product->category->name ?? 'Uncategorized' }}</span>
                            <h3 class="sp-name">
                                <a href="{{ route('products.show', $product->id) }}">{{ htmlspecialchars($product->name) }}</a>
                            </h3>

                            <div class="sp-price">
                                <span class="sp-old-price">JD {{ number_format($product->original_price, 2) }}</span>
                                <span class="sp-current-price">JD {{ number_format($product->new_price, 2) }}</span>
                            </div>

                            <div class="action-group">
                                <a href="{{ route('product.details', $product->id) }}" class="action-button cart-button">
                                    <span class="button-content">
                                        <svg class="button-icon" viewBox="0 0 24 24" width="18" height="18">
                                            <path d="M9 20a1 1 0 1 0 0 2 1 1 0 0 0 0-2zM19 20a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17" />
                                        </svg>
                                        <span class="button-text">Add</span>
                                    </span>
                                </a>

                                <div class="action-controls">
                                    @php
                                    $isInWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                                    ->where('product_id', $product->id)
                                    ->exists();
                                    @endphp

                                    <form action="{{ route('wishlist.add', $product->id) }}" method="POST" class="action-form">
                                        @csrf
                                        <button type="submit" class="icon-button wishlist-button">
                                            <svg class="heart-icon {{ $isInWishlist ? 'heart-added' : '' }}"
                                                viewBox="0 0 24 24" width="20" height="20">
                                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                            </svg>
                                        </button>
                                    </form>

                                    <a href="{{ route('product.details', $product->id) }}" class="icon-button details-button">
                                        <svg class="details-icon" viewBox="0 0 24 24" width="20" height="20">
                                            <path d="M12 2a10 10 0 1010 10A10 10 0 0012 2zm0 18a8 8 0 118-8 8 8 0 01-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endforeach
                </div>

                <div class="sp-pagination">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </section>
    <!-- End Sale Section -->

    </main>

</x-ecommerce-app-layout>
