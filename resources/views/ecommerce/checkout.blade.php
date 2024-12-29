<x-ecommerce-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
        <link rel="stylesheet" href="css/checkout.css">
        <link rel="javascript" href="js/checkout.js">
    </x-slot>

    <main class="main__content_wrapper">
        <section class="checkout__section section--padding">
            <div class="container">
                <div class="checkout__content">
                    <div class="row">
                        <!-- Order Summary -->
                        <div class="col-lg-5 mb-4 mb-lg-0">
                            <div class="order-summary p-4 bg-light rounded">
                                <h3 class="mb-4">Order Summary</h3>

                                <!-- Products List -->
                                <div class="order-products mb-4">
                                    @foreach($products as $product)
                                    <div class="order-product-item d-flex justify-content-between mb-3">
                                        <div>
                                            <h6>{{ $product['name'] }}</h6>
                                            <small>Quantity: {{ $product['quantity'] }}</small>
                                        </div>
                                        <span>JD {{ number_format($product['total'], 2) }}</span>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Order Totals -->
                                <div class="order-totals">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal:</span>
                                        <span>JD {{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Discount:</span>
                                        <span>JD {{ number_format($discount, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between font-weight-bold">
                                        <span>Total:</span>
                                        <span>JD {{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Checkout Form -->
                        <div class="col-lg-7">
                            <form action="{{ route('place.order') }}" method="POST" class="checkout-form">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="phone">Phone</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="address">Delivery Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3">Place Order</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-ecommerce-app-layout>
