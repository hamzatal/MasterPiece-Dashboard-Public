<x-ecommerce-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('Checkout') }}
        </h2>
    </x-slot>
    <main class="main__content_wrapper">
        <form action="#">
            <div class="checkout__content--step section__shipping--address pt-0">
                <div class="section__header checkout__header--style3 position__relative mb-25">
                    <span class="checkout__order--number">Order #0021</span>
                    <h2 class="section__header--title h3">Thank you submission</h2>
                    <div class="checkout__submission--icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25.995" height="25.979" viewBox="0 0 512 512">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M416 128L192 384l-96-96" />
                        </svg>
                    </div>
                </div>
                <div class="order__confirmed--area border-radius-5 mb-15">
                    <h3 class="order__confirmed--title h4">Your order is confirmed</h3>
                    <p class="order__confirmed--desc">You,ll receive a confirmation email with your order number shortly</p>
                </div>
                <div class="customer__information--area border-radius-5">
                    <h3 class="customer__information--title h4">Customer Information</h3>
                    <div class="customer__information--inner d-flex">
                        <div class="customer__information--list">
                            <div class="customer__information--step">
                                <h4 class="customer__information--subtitle h5">Contact information</h4>
                                <ul>
                                    <li><a class="customer__information--text__link" href="#">info42@gmail.com</a></li>
                                </ul>
                            </div>
                            <div class="customer__information--step">
                                <h4 class="customer__information--subtitle h5">Shipping address</h4>
                                <ul>
                                    <li><span class="customer__information--text">Amin</span></li>
                                    <li><span class="customer__information--text">Rajging</span></li>
                                    <li><span class="customer__information--text">Dhaka 12119</span></li>
                                    <li><span class="customer__information--text">Bangladesh</span></li>
                                </ul>
                            </div>
                            <div class="customer__information--step">
                                <h4 class="customer__information--subtitle h5">Shipping method</h4>
                                <ul>
                                    <li><span class="customer__information--text">Amin</span></li>
                                    <li><span class="customer__information--text">Rajging</span></li>
                                    <li><span class="customer__information--text">Dhaka 12119</span></li>
                                    <li><span class="customer__information--text">Bangladesh</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="customer__information--list">
                            <div class="customer__information--step">
                                <h4 class="customer__information--subtitle h5">Payment method</h4>
                                <ul>
                                    <li><span class="customer__information--text">ending With</span></li>
                                </ul>
                            </div>
                            <div class="customer__information--step">
                                <h4 class="customer__information--subtitle h5">Shipping method</h4>
                                <ul>
                                    <li><span class="customer__information--text">Amin</span></li>
                                    <li><span class="customer__information--text">Rajging</span></li>
                                    <li><span class="customer__information--text">Dhaka 12119</span></li>
                                    <li><span class="customer__information--text">Bangladesh</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="checkout__content--step__footer d-flex align-items-center">
                <a class="continue__shipping--btn primary__btn border-radius-5" href="/checkout">Pay now</a>
                <a class="previous__link--content" href="/shop-right-sidebar">Return to shipping</a>
            </div>
        </form>
    </main>

</x-ecommerce-app-layout>
