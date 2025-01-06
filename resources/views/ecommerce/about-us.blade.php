<x-ecommerce-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('about-us') }}
        </h2>
    </x-slot>

    <main class="main__content_wrapper">

        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">About Us</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">About Us</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- Start about section -->
        <section class="about__section section--padding mb-95">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="about__thumb d-flex">
                            <div class="about__thumb--items">
                                <img class="about__thumb--img border-radius-5 display-block" src="assets/img/other/about1.jpg" alt="about-thumb">
                            </div>
                            <div class="about__thumb--items position__relative">
                                <img class="about__thumb--img border-radius-5 display-block" src="assets/img/other/about3.jpg" alt="about-thumb">

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about__content">
                            <span class="about__content--subtitle text__secondary mb-20">So, You want to know a bit about us? Or maybe even a byte?
                            </span>
                            <h2 class="about__content--maintitle mb-25">We love programming and we also love jokes. We often find ourselves hitting 4:04 am error which in human terms mean sleep not found and it's a real success if we find ourselves in bed at 1:00 am.</h2>
                            <p class="about__content--desc mb-20">We provide a comprehensive platform that brings together all the tools and resources that programmers need to excel in their craft. From development tools to educational resources, libraries, and everything in between, we offer high-quality products directly from specialized developers. We do not buy from open markets or traders; we focus on providing the best, curated solutions for programmers.</p>
                            <p class="about__content--desc mb-25">On our platform, you'll find the perfect tools to improve your productivity and enhance your skills. Whether you're a beginner or an expert, we have everything you need to succeed in the programming world.</p>
                            <div class="about__author position__relative d-flex align-items-center">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- End about section -->

        <style>
            body {
                font-family: 'Poppins', sans-serif;
                line-height: 1.6;
                color: #333;
            }

            .text__secondary {
                color: rgb(170, 0, 0);
                font-size: 2rem;
                font-weight: 500;
            }

            .about__content--maintitle {
                font-size: 2rem;
                font-weight: 700;
                color: #2c3e50;
                margin-bottom: 1.5rem;
            }

            .about__content--desc {
                font-size: 1rem;
                color: #555;
                margin-bottom: 1.5rem;
            }

            .about__author {
                margin-top: 2rem;
            }

            .highlight {
                color: #e74c3c;
                font-weight: 600;
            }
        </style>

    </main>

</x-ecommerce-app-layout>
