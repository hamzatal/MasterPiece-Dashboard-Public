<x-ecommerce-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <main class="main__content_wrapper">
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

        <section class="checkout-container">
            <div class="checkout-header">
                <h1><i class="fas fa-shopping-cart"></i> Checkout</h1>
                <div class="checkout-steps">
                    <span class="step active"><i class="fas fa-shopping-basket"></i> Cart</span>
                    <span class="step-divider"></span>
                    <span class="step active"><i class="fas fa-address-card"></i> Details</span>
                    <span class="step-divider"></span>
                    <span class="step"><i class="fas fa-check-circle"></i> Confirmation</span>
                </div>
            </div>

            <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST" class="checkout-form">
                @csrf
                <div class="checkout-grid">
                    <div class="checkout-details">
                        <div class="form-section">
                            <h2><i class="fas fa-user"></i> Personal Information</h2>
                            <div class="input-group">
                                <input type="text" id="name" name="name" required>
                                <label for="name">Full Name</label>
                            </div>
                            <div class="input-group">
                                <input type="email" id="email" name="email" required>
                                <label for="email">Email Address</label>
                            </div>
                            <div class="input-group">
                                <input type="tel" id="phone" name="phone" required>
                                <label for="phone">Phone Number</label>
                            </div>
                        </div>

                        <div class="form-section">
                            <h2><i class="fas fa-shipping-fast"></i> Shipping Address</h2>
                            <div id="new-address-form" class="new-address-fields">
                                <div class="input-group">
                                    <input type="text" id="street_address" name="street_address">
                                    <label for="street_address">Street Address</label>
                                </div>
                                <div class="input-group-grid">
                                    <div class="input-group">
                                        <input type="text" id="city" name="city">
                                        <label for="city">City</label>
                                    </div>
                                    <div class="input-group">
                                        <input type="text" id="state" name="state">
                                        <label for="state">State</label>
                                    </div>
                                </div>
                                <div class="input-group-grid">
                                    <div class="input-group">
                                        <input type="text" id="zip_code" name="zip_code">
                                        <label for="zip_code">ZIP Code</label>
                                    </div>
                                    <div class="input-group">
                                        <input type="text" id="country" name="country">
                                        <label for="country">Country</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h2><i class="fas fa-credit-card"></i> Payment Method</h2>
                            <div class="payment-options">
                                <div class="payment-option">
                                    <input type="radio" id="paypal" name="payment" value="paypal" required>
                                    <label for="paypal">
                                        <span class="payment-icon paypal"><i class="fab fa-paypal"></i></span>
                                        PayPal
                                    </label>
                                </div>
                                <div class="payment-option">
                                    <input type="radio" id="visa" name="payment" value="visa">
                                    <label for="visa">
                                        <span class="payment-icon visa"><i class="fab fa-cc-visa"></i></span>
                                        Visa
                                    </label>
                                </div>
                                <div class="payment-option">
                                    <input type="radio" id="cash" name="payment" value="cash">
                                    <label for="cash">
                                        <span class="payment-icon cash"><i class="fas fa-money-bill-wave"></i></span>
                                        Cash on Delivery
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="order-summary">
                        <div class="summary-card">
                            <h2><i class="fas fa-clipboard-list"></i> Order Summary</h2>
                            <div class="summary-items">
                                @foreach($cartItems as $item)
                                <div class="summary-item">
                                    <span class="item-name">{{ $item->product->name }}</span>
                                    <span class="item-quantity">x{{ $item->quantity }}</span>
                                    <span class="item-price">JD {{ number_format($item->quantity * $item->product->new_price, 2) }}</span>
                                </div>
                                @endforeach
                            </div>
                            <div class="summary-totals">
                                <div class="summary-row">
                                    <span>Subtotal</span>
                                    <span>JD {{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="summary-row discount">
                                    <span>Discount</span>
                                    <span>- JD {{ number_format($discount, 2) }}</span>
                                </div>
                                <div class="summary-row total">
                                    <span>Total</span>
                                    <span>JD {{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-lock"></i> Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </section>




    </main>
</x-ecommerce-app-layout>
