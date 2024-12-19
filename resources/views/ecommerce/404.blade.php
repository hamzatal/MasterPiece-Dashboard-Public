<x-ecommerce-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('404 Error') }}
        </h2>
    </x-slot>


    <main class="main__content_wrapper">

        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Error 404</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Error 404</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- Start error section -->
        <section class="error__section section--padding">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="error__content text-center">
                            <img
                                class="error__content--img mb-50"
                                src="assets/img/other/404.jpg"
                                alt="error-img"
                                style="width: 500px; max-width: 100%; height: auto;">
                            <h2 class="error__content--title">Opps ! We,ar Not Found This Page </h2>
                            <p class="error__content--desc">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi animi aliquid minima assumenda.</p>
                            <a class="error__content--btn primary__btn" href="/home">Back To Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End error section -->


    </main>

</x-ecommerce-app-layout>
