<x-ecommerce-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Success') }}
        </h2>
    </x-slot>

    <main class="main__content_wrapper">
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="breadcrumb__content text-center">
                    <h1 class="breadcrumb__content--title text-white mb-25">Order Confirmation</h1>
                </div>
            </div>
        </section>

        <section class="confirmation-container">
            <div class="confirmation-header">
                <h1><i class="fas fa-check-circle"></i> Thank You for Your Order!</h1>
            </div>

            <div class="order-details">
                <h2>Order Details</h2>
                <p><strong>Order ID:</strong> {{ $order->id }}</p>
                <p><strong>Name:</strong> {{ $order->name }}</p>
                <p><strong>Total:</strong> JD {{ number_format($order->total_price, 2) }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst($order->payment) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            </div>

            <div class="shipping-address">
                <h2>Shipping Address</h2>
                <p>{{ $order->shippingAddress->street_address }}</p>
                <p>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}</p>
                <p>{{ $order->shippingAddress->zip_code }}, {{ $order->shippingAddress->country }}</p>
            </div>

            <div class="order-items">
                <h2>Order Items</h2>
                <ul>
                    @foreach($order->items as $item)
                    <li>
                        {{ $item->quantity }} x {{ $item->product->name }} - JD {{ number_format($item->price * $item->quantity, 2) }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </section>
    </main>
</x-ecommerce-app-layout>