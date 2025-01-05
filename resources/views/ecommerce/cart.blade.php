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

        <!-- Coupon Banner -->
        @if($coupon)
        <div class="coupon-notification">
            <div class="coupon-notification-content">
                <div class="coupon-notification-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
                        <path d="M9.375 3a1.875 1.875 0 000 3.75h1.875v4.5H3.375A1.875 1.875 0 011.5 9.375v-.75c0-1.036.84-1.875 1.875-1.875h3.193A3.375 3.375 0 0112 2.753a3.375 3.375 0 015.432 3.997h3.943c1.035 0 1.875.84 1.875 1.875v.75c0 1.036-.84 1.875-1.875 1.875H12.75v-4.5h1.875a1.875 1.875 0 10-1.875-1.875V6.75h-1.5V4.875C11.25 3.839 10.41 3 9.375 3zM11.25 12.75H3v6.75c0 1.035.84 1.875 1.875 1.875h9.375c1.035 0 1.875-.84 1.875-1.875v-6.75h-5.625zM12 10.5a.75.75 0 01.75.75v.75h.75a.75.75 0 010 1.5h-.75v.75a.75.75 0 01-1.5 0v-.75h-.75a.75.75 0 010-1.5h.75v-.75a.75.75 0 01.75-.75z" />
                    </svg>
                </div>
                <div class="coupon-notification-text">
                    <p style="color: white;">🎉 Special Offer! Use the code <strong>{{ $coupon->code }}</strong> to get <strong>{{ $coupon->discount_value }}%</strong> off your purchase. 🎉</p>
                </div>
                <button class="coupon-notification-close">&times;</button>
            </div>
        </div>
        @endif

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
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $item)
                                        <tr data-product-id="{{ $item['id'] }}">
                                            <td>
                                                <div class="cart-product-info d-flex align-items-center">
                                                    <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" class="cart-product-image">
                                                    <div>
                                                        <h6>{{ $item['name'] }}</h6>
                                                        <p class="text-muted">{{ $item['category'] }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $item['color'] ?? 'N/A' }}</td>
                                            <td>{{ $item['size'] ?? 'N/A' }}</td>
                                            <td>JD {{ number_format($item['price'], 2) }}</td>
                                            <td>
                                                <div class="quantity-controls">
                                                    <button type="button" class="quantity-decrease">-</button>
                                                    <input type="number" class="quantity-input" value="{{ $item['quantity'] }}" min="1">
                                                    <button type="button" class="quantity-increase">+</button>
                                                </div>
                                            </td>
                                            <td class="product-total">JD {{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                            <td>
                                                <button type="button" class="remove-item-btn">
                                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M3 6h18"></path>
                                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="cart-summary">
                                <div class="cart-summary-header">
                                    <h3>Cart Summary</h3>
                                </div>
                                <div class="cart-summary-content">
                                    <div class="coupon-section">
                                        @if(isset($appliedCoupon))
                                        <div class="applied-coupon">
                                            <p>Applied Coupon: <strong>{{ $appliedCoupon->code }}</strong> ({{ $appliedCoupon->discount_percentage }}% OFF)</p>
                                            <button type="button" class="btn btn-sm btn-danger" id="remove-coupon">Remove Coupon</button>
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
                                    <div class="checkout-section">
                                        <a href="{{ route('checkout') }}" class="btn btn-primary btn-block">
                                            Proceed to Checkout
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="empty-cart text-center">
                        <div class="empty-cart-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16" width="64" height="64">
                                <path d="M0 1a1 1 0 0 1 1-1h2.5a1 1 0 0 1 .96.74L5.58 4H14a1 1 0 0 1 .92 1.39l-1.5 3a1 1 0 0 1-.92.61H6.26l-.2 1H14.5a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.48-.36L4.01 5H1.5a.5.5 0 0 1 0-1h2.22l.9-3H1a1 1 0 0 1-1-1z" />
                                <path d="M7 13.5A1.5 1.5 0 1 0 8.5 15 1.5 1.5 0 0 0 7 13.5zm-3 0A1.5 1.5 0 1 0 5.5 15 1.5 1.5 0 0 0 4 13.5z" />
                            </svg>
                        </div>
                        <h3 class="empty-cart-title">Your cart is empty</h3>
                        <p class="empty-cart-message">It looks like you haven't added anything to your cart yet.</p>
                        <a href="{{ route('shop') }}" class="btn btn-primary">
                            Continue Shopping
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        <!-- Cart Section End -->

    </main>

</x-ecommerce-app-layout>
