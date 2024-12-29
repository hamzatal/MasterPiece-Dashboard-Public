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

        <!-- Start wishlist section -->
        <section class="wishlist__section section--padding">
            <div class="container">
                <div class="wishlist__section--inner">
                    <div class="row">
                        <div class="col-12">
                            <div class="wishlist-container">
                                @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif

                                @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif

                                @if($wishlistItems->count() > 0)
                                <div class="wishlist-items">
                                    @foreach($wishlistItems as $item)
                                    <div class="wishlist-item" data-item-id="{{ $item->id }}">
                                        <img class="border-radius-5" src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}">
                                        <div class="wishlist-item-details">
                                            <h3>Name: {{ $item->product->name }}</h3>
                                            <p>Description: {{ $item->product->description }}</p>
                                            @if($item->product->stock_quantity > 0)
                                            <span class="text-success">In Stock</span>
                                            @else
                                            <span class="text-danger">Out of Stock</span>
                                            @endif
                                        </div>

                                        <div class="wishlist-item-price">
                                            @if($item->product->original_price && $item->product->original_price > $item->product->new_price)
                                            <span class="text-decoration-line-through text-muted">
                                                JD {{ number_format($item->product->original_price, 2) }}
                                            </span>
                                            <span class="text-danger ms-2">
                                                JD {{ number_format($item->product->new_price, 2) }}
                                            </span>
                                            @else
                                            <span class="text-primary">
                                                JD {{ number_format($item->product->new_price, 2) }}
                                            </span>
                                            @endif
                                        </div>


                                        <div class="wishlist-actions">
                                            @if($item->product->stock_quantity > 0)
                                            <form action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                                </button>
                                            </form>
                                            @endif

                                            <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash-alt me-2"></i>Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach

                                    <div class="wishlist-footer">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <form action="{{ route('wishlist.clearAll') }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline" onclick="return confirm('Are you sure you want to clear your wishlist?')">
                                                    <i class="fas fa-trash me-2"></i>Clear Wishlist
                                                </button>
                                            </form>

                                            <a href="{{ route('products.index') }}" class="btn btn-outline">
                                                <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                                            </a>
                                        </div>

                                        @if($wishlistItems->hasPages())
                                        <div class="wishlist-pagination">
                                            <div class="pagination-container">
                                                {{ $wishlistItems->onEachSide(1)->links() }}
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @else
                                <div class="wishlist-empty">
                                    <i class="fas fa-heart text-muted mb-4" style="font-size: 3rem;"></i>
                                    <h3>Your wishlist is empty</h3>
                                    <p>Browse our products and add some items to your wishlist!</p>
                                    <a href="/shop" class="btn btn-primary mt-4">
                                        <i class="fas fa-shopping-bag me-2"></i>Browse Products
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- End wishlist section -->

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

    </main>

</x-ecommerce-app-layout>