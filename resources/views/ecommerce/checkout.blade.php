<x-ecommerce-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('Checkout') }}
        </h2>
    </x-slot>
    <main class="main__content_wrapper">
        <form action="#">
            <div class="checkout__content--step section__contact--information">
                <div class="section__header checkout__section--header d-flex align-items-center justify-content-between mb-25">
                    <h2 class="section__header--title h3">Contact information</h2>
                    <p class="layout__flex--item">
                        Already have an account?
                        <a class="layout__flex--item__link" href="login.html">Log in</a>
                    </p>
                </div>
                <div class="customer__information">
                    <div class="checkout__email--phone mb-12">
                        <label>
                            <input class="checkout__input--field border-radius-5" placeholder="Email or mobile phone mumber" type="text">
                        </label>
                    </div>
                    <div class="checkout__checkbox">
                        <input class="checkout__checkbox--input" id="check1" type="checkbox">
                        <span class="checkout__checkbox--checkmark"></span>
                        <label class="checkout__checkbox--label" for="check1">
                            Email me with news and offers</label>
                    </div>
                </div>
            </div>
            <div class="checkout__content--step section__shipping--address">
                <div class="section__header mb-25">
                    <h3 class="section__header--title">Shipping address</h3>
                </div>
                <div class="section__shipping--address__content">
                    <div class="row">
                        <div class="col-lg-6 mb-12">
                            <div class="checkout__input--list ">
                                <label>
                                    <input class="checkout__input--field border-radius-5" placeholder="First name (optional)" type="text">
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-12">
                            <div class="checkout__input--list">
                                <label>
                                    <input class="checkout__input--field border-radius-5" placeholder="Last name" type="text">
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mb-12">
                            <div class="checkout__input--list">
                                <label>
                                    <input class="checkout__input--field border-radius-5" placeholder="Company (optional)" type="text">
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mb-12">
                            <div class="checkout__input--list">
                                <label>
                                    <input class="checkout__input--field border-radius-5" placeholder="Address1" type="text">
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mb-12">
                            <div class="checkout__input--list">
                                <label>
                                    <input class="checkout__input--field border-radius-5" placeholder="Apartment, suite, etc. (optional)" type="text">
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mb-12">
                            <div class="checkout__input--list">
                                <label>
                                    <input class="checkout__input--field border-radius-5" placeholder="City" type="text">
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-12">
                            <div class="checkout__input--list checkout__input--select select">
                                <label class="checkout__select--label" for="country">Country/region</label>
                                <select class="checkout__input--select__field border-radius-5" id="country">
                                    <option value="1">India</option>
                                    <option value="2">United States</option>
                                    <option value="3">Netherlands</option>
                                    <option value="4">Afghanistan</option>
                                    <option value="5">Islands</option>
                                    <option value="6">Albania</option>
                                    <option value="7">Antigua Barbuda</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-12">
                            <div class="checkout__input--list">
                                <label>
                                    <input class="checkout__input--field border-radius-5" placeholder="Postal code" type="text">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="checkout__checkbox">
                        <input class="checkout__checkbox--input" id="check2" type="checkbox">
                        <span class="checkout__checkbox--checkmark"></span>
                        <label class="checkout__checkbox--label" for="check2">
                            Save this information for next time</label>
                    </div>
                </div>
            </div>
            <div class="checkout__content--step__footer d-flex align-items-center">
                <a class="continue__shipping--btn primary__btn border-radius-5" href="checkout-2.html">Continue To Shipping</a>
                <a class="previous__link--content" href="cart.html">Return to cart</a>
            </div>
        </form>
    </main>

</x-ecommerce-app-layout>
