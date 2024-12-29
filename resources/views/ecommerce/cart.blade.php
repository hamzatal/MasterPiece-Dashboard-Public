<x-ecommerce-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cart') }}
        </h2>
        <link rel="stylesheet" href="css/cart.css">
        <link rel="javascript" href="js/cart.js">
    </x-slot>

    <main class="main__content_wrapper">
        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Shopping Cart</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Shopping Cart</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- Cart Section Start -->
        <section class="cart__section section--padding">
            <div class="container-fluid">
                <div class="cart__section--inner">
                    @if(count($products) > 0)
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="cart-table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                        <tr data-product-id="{{ $product['id'] }}">
                                            <td>
                                                <div class="cart-product-info d-flex align-items-center">
                                                    <img src="{{ Storage::url($product['image']) }}" alt="{{ $product['name'] }}" class="cart-product-image">
                                                    <div>
                                                        <h4>{{ $product['name'] }}</h4>
                                                        <p>Category: {{ $product['category'] }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>JD {{ number_format($product['price'], 2) }}</td>
                                            <td>
                                                <div class="quantity-controls">
                                                    <button type="button" class="quantity-decrease">-</button>
                                                    <input type="number" class="quantity-input" value="{{ $product['quantity'] }}" min="1">
                                                    <button type="button" class="quantity-increase">+</button>
                                                </div>
                                            </td>
                                            <td class="product-total">JD {{ number_format($product['total'], 2) }}</td>
                                            <td>
                                                <form action="{{ route('cart.remove', $product['id']) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="remove-item-btn">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M3 6h18"></path>
                                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="cart-actions mt-4">
                                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Clear Cart</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="cart-summary">
                                <h3>Cart Summary</h3>
                                <div class="coupon-section">
                                    @if(isset($appliedCoupon))
                                    <div class="applied-coupon">
                                        <p>Applied Coupon: <strong>{{ $appliedCoupon->code }}</strong> ({{ $appliedCoupon->discount_percentage }}% OFF)</p>
                                        <form action="{{ route('cart.removeCoupon') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Remove Coupon</button>
                                        </form>
                                    </div>
                                    @else
                                    <div class="coupon-section mb-4">
                                        <div class="coupon-form">
                                            <input type="text" id="coupon-code" placeholder="Enter coupon code" class="form-control">
                                            <button type="button" id="apply-coupon" class="btn btn-primary">Apply Coupon</button>
                                        </div>
                                        <div id="coupon-message" class="mt-2"></div>
                                    </div>
                                    @endif
                                </div>
                                <div class="cart-totals">
                                    <div class="total-row">
                                        <span>Subtotal:</span>
                                        <span class="subtotal-amount">JD {{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    <div class="total-row">
                                        <span>Discount:</span>
                                        <span class="discount-amount">JD {{ number_format($discount, 2) }}</span>
                                    </div>
                                    <div class="total-row grand-total">
                                        <span>Total:</span>
                                        <span class="cart-total">JD {{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="checkout-section mt-4">
                                <a href="{{ route('checkout') }}" class="btn btn-success w-100 py-3">
                                    Proceed to Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="empty-cart text-center">
                <h3>Your cart is empty</h3>
                <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
            </div>
            @endif
            </div>
            </div>
        </section>
        <!-- Cart Section End -->
    </main>
</x-ecommerce-app-layout>
