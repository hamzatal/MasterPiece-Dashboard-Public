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

        <section class="checkout-container">
            <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                @csrf
                @if ($errors->any())
                <div class="error-alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(session('error'))
                <div class="error-alert">
                    {{ session('error') }}
                </div>
                @endif

                <div class="checkout-grid">
                    <!-- Shipping Address -->
                    <div class="shipping-section">
                        <div class="section-header">
                            <i class="fas fa-user-circle"></i>
                            <h3>Personal Information</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="name"><i class="fas fa-user"></i> Full Name</label>
                                <input type="text" name="name" id="name" class="form-input" value="{{ auth()->user()->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                                <input type="email" name="email" id="email" class="form-input" value="{{ auth()->user()->email }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="phone"><i class="fas fa-phone"></i> Phone Number</label>
                                <input type="tel" name="phone" id="phone" class="form-input" value="{{ auth()->user()->phone }}" required>
                            </div>
                        </div>

                        <div class="section-header">
                            <i class="fas fa-shipping-fast"></i>
                            <h3>Shipping Address</h3>
                        </div>
                        <div class="form-group">
                            <label for="address_type"><i class="fas fa-map-marker-alt"></i> Address Type</label>
                            <select name="address_type" id="address_type" class="form-input" required>
                                <option value="home" {{ old('address_type') == 'home' ? 'selected' : '' }}>Home</option>
                                <option value="work" {{ old('address_type') == 'work' ? 'selected' : '' }}>Work</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="street_address"><i class="fas fa-road"></i>Address</label>
                            <input type="text" name="street_address" id="street_address" class="form-input" required>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="city"><i class="fas fa-city"></i> City</label>
                                <input type="text" name="city" id="city" class="form-input" required>
                            </div>


                            <div class="form-group">
                                <label for="country"><i class="fas fa-globe"></i> Country</label>
                                <input type="text" name="country" id="country" class="form-input" required>
                            </div>
                        </div>
                        <div class="section-header">
                            <i class="fas fa-credit-card"></i>
                            <h3>Payment Method</h3>
                        </div>
                        <div class="payment-options">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cash" required>
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Cash</span>
                            </label>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="order-summary">
                        <div class="section-header">
                            <i class="fas fa-shopping-cart"></i>
                            <h3>Order Summary</h3>
                        </div>
                        <div class="order-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product['name'] }}</td>
                                        <td>{{ $product['color'] ?? 'N/A' }}</td>
                                        <td>{{ $product['size'] ?? 'N/A' }}</td>
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
                        <button type="submit" class="btn-place-order">
                            <i class="fas fa-lock"></i> Place Order
                        </button>
                    </div>
                </div>

                <!-- Hidden fields -->
                <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                <input type="hidden" name="discount" value="{{ $discount }}">
                <input type="hidden" name="total" value="{{ $total }}">
            </form>
        </section>

    </main>

</x-ecommerce-app-layout>