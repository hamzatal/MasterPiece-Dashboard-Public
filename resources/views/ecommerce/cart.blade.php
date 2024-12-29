<x-ecommerce-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('Cart') }}
        </h2>
    </x-slot>

    <main class="main__content_wrapper">

        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Shopping Cart</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Shopping Cart</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- Cart Section Start -->
        <section class="cart__section section--padding">
            <div class="container-fluid">
                <div class="cart__section--inner">
                    <form action="#">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="cart__table">
                                    @if(session('cart') && count(session('cart')) > 0)
                                    <table class="cart__table--inner">
                                        <thead class="cart__table--header">
                                            <tr class="cart__table--header__items">
                                                <th class="cart__table--header__list">Product</th>
                                                <th class="cart__table--header__list">Price</th>
                                                <th class="cart__table--header__list">Quantity</th>
                                                <th class="cart__table--header__list">Total</th>
                                                <th class="cart__table--header__list">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="cart__table--body">

                                        </tbody>
                                    </table>
                                    @else
                                    <div class="text-center p-5">
                                        <h3>Your cart is empty!</h3>
                                    </div>
                                    @endif
                                </div>
                                <div class="continue__shopping d-flex justify-content-between">
                                    <a class="continue__shopping--link" href="/shop">Continue shopping</a>
                                    <button type="button" class="continue__shopping--clear" id="clear-cart">Clear Cart</button>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="cart__summary border-radius-10">
                                    <div class="cart__summary--total mb-20">
                                        <table class="cart__summary--total__table">
                                            <tbody>
                                                <tr class="cart__summary--total__list">
                                                    <td class="cart__summary--total__title text-left">SUBTOTAL</td>
                                                    <td class="cart__summary--amount text-right" id="cart-subtotal">JD {{ number_format(collect(session('cart'))->sum(fn($item) => $item['price'] * $item['quantity']), 2) }}</td>
                                                </tr>
                                                <tr class="cart__summary--total__list">
                                                    <td class="cart__summary--total__title text-left">GRAND TOTAL</td>
                                                    <td class="cart__summary--amount text-right" id="cart-grandtotal">JD {{ number_format(collect(session('cart'))->sum(fn($item) => $item['price'] * $item['quantity']), 2) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="cart__summary--footer">
                                        <ul class="d-flex justify-content-between">
                                            <li><button class="cart__summary--footer__btn primary__btn cart" type="button" id="update-cart">Update Cart</button></li>
                                            <li><a class="cart__summary--footer__btn primary__btn checkout" href="/checkout">Check Out</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- Cart Section End -->

    </main>

</x-ecommerce-app-layout>