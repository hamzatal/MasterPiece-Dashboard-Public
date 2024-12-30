<x-ecommerce-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('Order Confirmation') }}
        </h2>
        <link rel="stylesheet" href="css/order-confirmation.css">

    </x-slot>

    <main class="main__content_wrapper">

        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Order Confirmation</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Order Confirmation</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- Start confirmation section -->
        <section class="receipt">
            <div class="receipt__container">
                <div class="receipt__header">
                    <div class="receipt__logo">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M8 12l3 3 5-5" />
                        </svg>
                        <h1>Order Confirmed!</h1>
                    </div>
                    <div class="receipt__meta">
                        <div class="receipt__meta-item">
                            <span>Order ID:</span>
                            <strong>#{{ $order->id }}</strong>
                        </div>
                        <div class="receipt__meta-item">
                            <span>Date:</span>
                            <strong>{{ $order->created_at->format('M d, Y') }}</strong>
                        </div>
                    </div>
                </div>

                <div class="receipt__content">
                    <!-- Left Column -->
                    <div class="receipt__column">
                        <div class="receipt__section">
                            <h2>Order Details</h2>
                            <div class="receipt__items">
                                @foreach($order->items as $item)
                                <div class="receipt__item">
                                    <div class="receipt__item-details">
                                        <h3>{{ $item->product->name }}</h3>
                                        <p>Quantity: {{ $item->quantity }}</p>
                                    </div>
                                    <div class="receipt__item-price">
                                        <span>JD {{ number_format($item->price, 2) }}</span>
                                        <strong>JD {{ number_format($item->price * $item->quantity, 2) }}</strong>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="receipt__section">
                            <h2>Payment Information</h2>
                            <div class="receipt__payment">
                                <div class="receipt__payment-method">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                                        <line x1="1" y1="10" x2="23" y2="10" />
                                    </svg>
                                    <span>{{ ucfirst($order->payment_method) }}</span>
                                </div>
                                <div class="receipt__totals">
                                    <div class="receipt__total-row">
                                        <span>Subtotal</span>
                                        <span>JD {{ number_format($order->price, 2) }}</span>
                                    </div>
                                    <div class="receipt__total-row">
                                        <span>Discount</span>
                                        <span>-JD {{ number_format($order->discount, 2) }}</span>
                                    </div>
                                    <div class="receipt__total-row receipt__total-row--final">
                                        <span>Total</span>
                                        <strong>JD {{ number_format($order->total_price, 2) }}</strong>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="receipt__column">
                        <div class="receipt__section">
                            <h2>Shipping Details</h2>
                            <div class="receipt__shipping">
                                <div class="receipt__address">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    <div>
                                        <h3>Delivery Address</h3>
                                        <p>{{ $order->shippingAddress->street_address }}</p>
                                        <p>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}</p>
                                        <p>{{ $order->shippingAddress->country }}, {{ $order->shippingAddress->zip_code }}</p>
                                    </div>
                                </div>
                                <div class="receipt__status">
                                    <h3>Order Status</h3>
                                    <div class="receipt__status-badge">{{ ucfirst($order->status) }}</div>
                                    <div class="receipt__status-timeline">
                                        <div class="receipt__status-step receipt__status-step--active">
                                            <div class="receipt__status-dot"></div>
                                            <span>Order Confirmed</span>
                                        </div>
                                        <div class="receipt__status-step">
                                            <div class="receipt__status-dot"></div>
                                            <span>Processing</span>
                                        </div>
                                        <div class="receipt__status-step">
                                            <div class="receipt__status-dot"></div>
                                            <span>Shipped</span>
                                        </div>
                                        <div class="receipt__status-step">
                                            <div class="receipt__status-dot"></div>
                                            <span>Delivered</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="receipt__section">
                            <h2>Customer Support</h2>
                            <div class="receipt__support">
                                <p>Need help with your order?</p>
                                <div class="receipt__support-contact">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                                    </svg>
                                    <a href="/contact" class="receipt__btn__help">Contact Support</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="receipt__actions">
                    <a href="/home" class="receipt__btn">Return Home</a>
                    <button class="receipt__btn receipt__btn--outline">Download Invoice</button>
                </div>
            </div>
        </section>


        <!-- End confirmation section -->

    </main>
</x-ecommerce-app-layout>
