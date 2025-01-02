<x-ecommerce-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Info') }}
        </h2>
    </x-slot>

    <main class="main__content_wrapper">

        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Order Info</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Order</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- Start Order Details Section -->
        <section class="order-details section--padding">
            <div class="container">
                @if($orders->isNotEmpty())
                @foreach($orders as $order)
                <div class="order-wrapper mb-5">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="order-details__content">
                                <h3 class="order-details__title">Order #{{ $order->id }}</h3>
                                <ul class="order-details__list">
                                    <li><strong>Order Date:</strong> {{ $order->created_at->format('d M, Y') }}</li>
                                    <li><strong>Status:</strong> {{ ucfirst($order->status) }}</li>
                                    <li><strong>Total Amount:</strong> ${{ number_format($order->total_price, 2) }}</li>
                                    <li><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</li>
                                </ul>

                                <h4 class="mt-4">Shipping Address:</h4>
                                @if($order->shippingAddress)
                                <address>
                                    {{ $order->shippingAddress->name }}<br>
                                    {{ $order->shippingAddress->street_address }}<br>
                                    {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}<br>
                                    {{ $order->shippingAddress->zip_code }}<br>
                                    {{ $order->shippingAddress->country }}
                                </address>
                                @else
                                <p>No shipping address available.</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="order-summary">
                                <h3 class="order-summary__title">Order Summary</h3>
                                <ul class="order-summary__list">
                                    <li><span>Subtotal:</span> <span>${{ number_format($order->subtotal, 2) }}</span></li>
                                    <li><span>Discount:</span> <span>-${{ number_format($order->discount, 2) }}</span></li>
                                    <li><span>Total:</span> <span>${{ number_format($order->total_price, 2) }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-lg-12">
                            <h4>Order Items</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name ?? 'Product not found' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr>
                @endforeach
                @else
                <div class="row">
                    <div class="col-lg-12">
                        <p class="alert alert-warning">No orders found.</p>
                    </div>
                </div>
                @endif
            </div>
        </section>
        <!-- End Order Details Section -->


    </main>
</x-ecommerce-app-layout>
