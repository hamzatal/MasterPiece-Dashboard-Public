<x-ecommerce-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Frequently Asked Questions') }}
        </h2>
    </x-slot>

    <main class="main__content_wrapper">

        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Frequently Asked Questions</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">FAQs</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- FAQ Page Section Start -->
        <section class="faq__section section--padding">
            <div class="container">
                <div class="faq__section--inner">
                    <!-- FAQ Category -->
                    <div class="faq-category mb-5">
                        <h2 class="faq-category-title mb-4">
                            <i class="fas fa-shipping-fast me-2"></i>Shipping Information
                        </h2>
                        <div class="accordion" id="shippingInfoAccordion">
                            <!-- FAQ Item -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        What Shipping Methods Are Available?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#shippingInfoAccordion">
                                    <div class="accordion-body">
                                        We offer standard, express, and overnight shipping methods to suit your needs.
                                    </div>
                                </div>
                            </div>
                            <!-- FAQ Item -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        How Long Will It Take To Get My Package?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#shippingInfoAccordion">
                                    <div class="accordion-body">
                                        Delivery times vary based on your location and shipping method, but typically range from 2-7 business days.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="faq-category mb-5">
                        <h2 class="faq-category-title mb-4">
                            <i class="fas fa-credit-card me-2"></i>Payment Information
                        </h2>
                        <div class="accordion" id="paymentInfoAccordion">
                            <!-- FAQ Item -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="paymentOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePaymentOne" aria-expanded="true" aria-controls="collapsePaymentOne">
                                        What payment methods are accepted?
                                    </button>
                                </h2>
                                <div id="collapsePaymentOne" class="accordion-collapse collapse show" aria-labelledby="paymentOne" data-bs-parent="#paymentInfoAccordion">
                                    <div class="accordion-body">
                                        We accept all major credit cards, PayPal, and bank transfers.
                                    </div>
                                </div>
                            </div>
                            <!-- FAQ Item -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="paymentTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePaymentTwo" aria-expanded="false" aria-controls="collapsePaymentTwo">
                                        Can I pay using a Gift Card?
                                    </button>
                                </h2>
                                <div id="collapsePaymentTwo" class="accordion-collapse collapse" aria-labelledby="paymentTwo" data-bs-parent="#paymentInfoAccordion">
                                    <div class="accordion-body">
                                        Yes, you can use our gift cards during checkout. Just enter the code in the payment section.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orders and Returns -->
                    <div class="faq-category">
                        <h2 class="faq-category-title mb-4">
                            <i class="fas fa-box-open me-2"></i>Orders and Returns
                        </h2>
                        <div class="accordion" id="ordersReturnsAccordion">
                            <!-- FAQ Item -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="orderOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrderOne" aria-expanded="true" aria-controls="collapseOrderOne">
                                        How can I return an item?
                                    </button>
                                </h2>
                                <div id="collapseOrderOne" class="accordion-collapse collapse show" aria-labelledby="orderOne" data-bs-parent="#ordersReturnsAccordion">
                                    <div class="accordion-body">
                                        You can initiate a return within 30 days of receiving your order. Visit our returns page for detailed instructions.
                                    </div>
                                </div>
                            </div>
                            <!-- FAQ Item -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="orderTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrderTwo" aria-expanded="false" aria-controls="collapseOrderTwo">
                                        How do I track my order?
                                    </button>
                                </h2>
                                <div id="collapseOrderTwo" class="accordion-collapse collapse" aria-labelledby="orderTwo" data-bs-parent="#ordersReturnsAccordion">
                                    <div class="accordion-body">
                                        Use the tracking number sent to your email or visit the "Track My Order" page on our website.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- FAQ Page Section End -->

    </main>
</x-ecommerce-app-layout>
