<x-ecommerce-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
        <link rel="stylesheet" href="css/checkout.css">
        <link rel="javascript" href="js/checkout.js">
    </x-slot>

    <main class="checkout__page">
        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Checkout</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Checkout</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <section class="checkout__section section--padding">
            <div class="container">
                <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                    @csrf
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="row">
                        <!-- Shipping Address -->
                        <div class="col-md-6">
                            <div class="checkout-form p-4">
                                <div class="col-md-12 mb-4">
                                    <div class="section-title">
                                        <h3><i class="fas fa-user-circle me-2"></i>Personal Information</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name"><i class="fas fa-user me-2"></i>Full Name</label>
                                                <input type="text" name="name" id="name" class="form-control" value="{{ auth()->user()->name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email"><i class="fas fa-envelope me-2"></i>Email</label>
                                                <input type="email" name="email" id="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="phone"><i class="fas fa-phone me-2"></i>Phone Number</label>
                                                <input type="tel" name="phone" id="phone" class="form-control" value="{{ auth()->user()->phone }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <div class="section-title">
                                        <h3><i class="fas fa-shipping-fast me-2"></i>Shipping Address</h3>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_type"><i class="fas fa-map-marker-alt me-2"></i>Address Type</label>
                                        <select name="address_type" id="address_type" class="form-control" required>
                                            <option value="home" {{ old('address_type') == 'home' ? 'selected' : '' }}>
                                                <i class="fas fa-home"></i> Home
                                            </option>
                                            <option value="work" {{ old('address_type') == 'work' ? 'selected' : '' }}>
                                                <i class="fas fa-building"></i> Work
                                            </option>
                                        </select>
                                    </div>

                                    <div class="address-fields">
                                        <div class="form-group">
                                            <label for="street_address"><i class="fas fa-road me-2"></i>Street Address</label>
                                            <input type="text" name="street_address" id="street_address" class="form-control" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="city"><i class="fas fa-city me-2"></i>City</label>
                                                    <input type="text" name="city" id="city" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="state"><i class="fas fa-map me-2"></i>State</label>
                                                    <input type="text" name="state" id="state" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="zip_code"><i class="fas fa-mail-bulk me-2"></i>Zip Code</label>
                                                    <input type="text" name="zip_code" id="zip_code" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="country"><i class="fas fa-globe me-2"></i>Country</label>
                                                    <input type="text" name="country" id="country" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group payment-method mt-4">
                                        <div class="section-title">
                                            <h3><i class="fas fa-credit-card me-2"></i>Payment Method</h3>
                                        </div>
                                        <div class="payment-options">
                                            <!-- <label class="payment-option">
                                                <input type="radio" name="payment_method" value="visa" required onclick="showPaymentModal('visa')">
                                                <span class="payment-icon"><i class="fab fa-cc-visa"></i></span>
                                                <span class="payment-label">Visa</span>
                                            </label>
                                            <label class="payment-option">
                                                <input type="radio" name="payment_method" value="paypal" required onclick="showPaymentModal('paypal')">
                                                <span class="payment-icon"><i class="fab fa-paypal"></i></span>
                                                <span class="payment-label">PayPal</span>
                                            </label> -->
                                            <label class="payment-option">
                                                <input type="radio" name="payment_method" value="cash" required>
                                                <span class="payment-icon"><i class="fas fa-money-bill-wave"></i></span>
                                                <span class="payment-label">Cash</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="col-md-6">
                            <div class="order-summary p-4">
                                <div class="section-title">
                                    <h3><i class="fas fa-shopping-cart me-2"></i>Order Summary</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($products as $product)
                                            <tr>
                                                <td>{{ $product['name'] }}</td>
                                                <td>{{ $product['quantity'] }}</td>
                                                <td>JD {{ number_format($product['price'], 2) }}</td>
                                                <td>JD {{ number_format($product['total'], 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="totals">
                                    <div class="total-row">
                                        <span>Subtotal:</span>
                                        <span>JD {{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    <div class="total-row">
                                        <span>Discount:</span>
                                        <span>JD {{ number_format($discount, 2) }}</span>
                                    </div>
                                    <div class="total-row grand-total">
                                        <span>Total:</span>
                                        <span>JD {{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block mt-4">
                                    <i class="fas fa-lock me-2"></i>Place Order
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden fields -->
                    <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                    <input type="hidden" name="discount" value="{{ $discount }}">
                    <input type="hidden" name="total" value="{{ $total }}">
                </form>
            </div>
        </section>
    </main>
</x-ecommerce-app-layout>
