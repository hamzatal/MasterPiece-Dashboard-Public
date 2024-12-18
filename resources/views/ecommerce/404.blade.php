<x-ecommerce-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('404 Error') }}
        </h2>
    </x-slot>

    <!-- Start error section -->
    <section class="errorsection section--padding">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="errorcontent text-center">
                        <img class="errorcontent--img display-block mb-50" src="assets/img/other/404-thumb.webp" alt="error-img">
                        <h2 class="errorcontent--title">Opps ! We,ar Not Found This Page </h2>
                        <p class="errorcontent--desc">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi animi aliquid minima assumenda.</p>
                        <a class="errorcontent--btn primarybtn" href="index-2.html">Back To Home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End error section -->

    <!-- Start shipping section -->
    <section class="shippingsection">
        <div class="container">
            <div class="shippinginner style2 d-flex">
                <div class="shippingitems style2 d-flex align-items-center">
                    <div class="shippingicon">
                        <img src="assets/img/other/shipping1.webp" alt="icon-img">
                    </div>
                    <div class="shippingcontent">
                        <h2 class="shippingcontent--title h3">Free Shipping</h2>
                        <p class="shippingcontent--desc">Free shipping over $100</p>
                    </div>
                </div>
                <div class="shippingitems style2 d-flex align-items-center">
                    <div class="shippingicon">
                        <img src="assets/img/other/shipping2.webp" alt="icon-img">
                    </div>
                    <div class="shippingcontent">
                        <h2 class="shippingcontent--title h3">Support 24/7</h2>
                        <p class="shippingcontent--desc">Contact us 24 hours a day</p>
                    </div>
                </div>
                <div class="shippingitems style2 d-flex align-items-center">
                    <div class="shippingicon">
                        <img src="assets/img/other/shipping3.webp" alt="icon-img">
                    </div>
                    <div class="shippingcontent">
                        <h2 class="shippingcontent--title h3">100% Money Back</h2>
                        <p class="shippingcontent--desc">You have 30 days to Return</p>
                    </div>
                </div>
                <div class="shippingitems style2 d-flex align-items-center">
                    <div class="shippingicon">
                        <img src="assets/img/other/shipping4.webp" alt="icon-img">
                    </div>
                    <div class="shippingcontent">
                        <h2 class="shippingcontent--title h3">Payment Secure</h2>
                        <p class="shippingcontent--desc">We ensure secure payment</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End shipping section -->

</x-ecommerce-app-layout>
