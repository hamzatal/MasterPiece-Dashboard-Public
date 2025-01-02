<x-ecommerce-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('Product Details') }}
        </h2>
        <link rel="javascript" href="js/product-details.js">

    </x-slot>

    <main class="main__content_wrapper">

        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Product Details</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Product Details</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- Start product details section -->
        <section class="product__details--section section--padding">
            <div class="container">
                <div class="row row-cols-lg-2 row-cols-md-2 row-cols-1">
                    <div class="col">
                        <div class="product__details--gallery">
                            <div class="row row-cols-2 mb--n28">
                                @if($product->image1)
                                <div class="col mb-28">
                                    <img class="display-block" src="{{ asset('storage/' . $product->image1) }}" alt="{{ $product->name }}">
                                </div>
                                @endif
                                @if($product->image2)
                                <div class="col mb-28">
                                    <img class="display-block" src="{{ asset('storage/' . $product->image2) }}" alt="{{ $product->name }}">
                                </div>
                                @endif
                                @if($product->image3)
                                <div class="col mb-28">
                                    <img class="display-block" src="{{ asset('storage/' . $product->image3) }}" alt="{{ $product->name }}">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="product__details--info">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <h2 class="product__details--info__title mb-15">{{ $product->name }}</h2>
                                <p class="product__details--info__meta--list"><strong>Category:</strong> <span>{{ $product->category->name ?? 'N/A' }}</span></p>

                                <div class="product__details--info__price mb-10">
                                    <span class="current__price">${{ number_format($product->new_price, 2) }}</span>
                                    @if($product->original_price)
                                    <span class="price__divided"></span>
                                    <span class="old__price">${{ number_format($product->original_price, 2) }}</span>
                                    @endif
                                </div>

                                @if($product->rating)
                                <div class="product__details--info__rating d-flex align-items-center mb-15">
                                    <ul class="rating d-flex justify-content-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="{{ $i <= $product->rating ? 'currentColor' : '#ccc' }}"></path>
                                                </svg>
                                            </span>
                                            </li>
                                            @endfor
                                    </ul>
                                    <span class="product__items--rating__count--number">({{ $product->reviews_count ?? 0 }})</span>
                                </div>
                                @endif

                                <p class="product__details--info__desc mb-15">{{ $product->name }}</p>

                                <div class="product__variant">
                                    @if($product->color)
                                    <div class="product__variant--list mb-10">
                                        <fieldset class="variant__input--fieldset">
                                            <legend class="product__variant--title mb-8">Color :</legend>
                                            @foreach(explode(',', $product->color) as $color)
                                            <input id="color-{{ $loop->index }}" name="color" type="radio" {{ $loop->first ? 'checked' : '' }}>
                                            <label class="variant__color--value" for="color-{{ $loop->index }}" title="{{ trim($color) }}">
                                                <span class="variant__color--value__name">{{ trim($color) }}</span>
                                            </label>
                                            @endforeach
                                        </fieldset>
                                    </div>
                                    @endif

                                    @if($product->size)
                                    <div class="product__variant--list mb-15">
                                        <fieldset class="variant__input--fieldset weight">
                                            <legend class="product__variant--title mb-8">Size :</legend>
                                            @foreach(explode(',', $product->size) as $size)
                                            <input id="size-{{ $loop->index }}" name="size" type="radio" {{ $loop->first ? 'checked' : '' }}>
                                            <label class="variant__size--value" for="size-{{ $loop->index }}">{{ trim($size) }}</label>
                                            @endforeach
                                        </fieldset>
                                    </div>
                                    @endif

                                    <div class="product__variant--list quantity d-flex align-items-center mb-20">
                                        <div class="quantity__box">
                                            <button type="button" class="quantity__value decrease" aria-label="quantity value" value="Decrease Value">-</button>
                                            <label>
                                                <input type="number" name="quantity" class="quantity__number" value="1" min="1" max="{{ $product->stock_quantity }}" />
                                            </label>
                                            <button type="button" class="quantity__value increase" aria-label="quantity value" value="Increase Value">+</button>
                                        </div>
                                    </div>

                                    <div class="product__variant--list mb-15">
                                        <a class="variant__wishlist--icon mb-15" href="{{ route('wishlist.add', $product->id) }}" title="Add to wishlist">
                                            <svg class="quickview__variant--wishlist__svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path d="M352.92 80C288 80 256 144 256 144s-32-64-96.92-64c-52.76 0-94.54 44.14-95.08 96.81-1.1 109.33 86.73 187.08 183 252.42a16 16 0 0018 0c96.26-65.34 184.09-143.09 183-252.42-.54-52.67-42.32-96.81-95.08-96.81z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                                            </svg>
                                            Add to Wishlist
                                        </a>
                                        <form action="{{ route('cart.add') }}" method="POST" class="sp-form">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="sp-button sp-button-cart">Add to Cart</button>
                                        </form>
                                    </div>

                                    <div class="product__details--info__meta">
                                        @if($product->is_on_sale)
                                        <p class="product__details--info__meta--list"><strong>Discount:</strong> <span>{{ $product->discount_percentage }}%</span></p>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Start product details tab section -->
        <section class="product__details--tab__section section--padding">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <ul class="product__details--tab d-flex mb-30">
                            <li class="product__details--tab__list active" data-toggle="tab" data-target="#description">Description</li>
                            <li class="product__details--tab__list" data-toggle="tab" data-target="#reviews">Product Reviews</li>
                        </ul>
                        <div class="product__details--tab__inner border-radius-10">
                            <div class="tab_content">
                                <div id="description" class="tab_pane active show">
                                    <div class="product__tab--content">
                                        <div class="product__tab--content__step mb-30">
                                            <h2 class="product__tab--content__title h4 mb-10">Nam provident sequi</h2>
                                            <p class="product__tab--content__desc">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam provident sequi, nemo sapiente culpa nostrum rem eum perferendis quibusdam, magnam a vitae corporis! Magnam enim modi, illo harum suscipit tempore aut dolore doloribus deserunt voluptatum illum, est porro? Ducimus dolore accusamus impedit ipsum maiores, ea iusto temporibus numquam eaque mollitia fugiat laborum dolor tempora eligendi voluptatem quis necessitatibus nam ab?</p>
                                        </div>

                                    </div>
                                </div>
                                <div id="reviews" class="tab_pane">
                                    <div class="product__reviews">
                                        <div class="product__reviews--header">
                                            <h2 class="product__reviews--header__title h3 mb-20">Customer Reviews</h2>

                                            <a class="actions__newreviews--btn primary__btn" href="#writereview">Write A Review</a>
                                        </div>
                                        <div class="reviews__comment--area">
                                            <div class="reviews__comment--list d-flex">

                                                <div class="reviews__comment--content">
                                                    <div class="reviews__comment--top d-flex justify-content-between">
                                                        <div class="reviews__comment--top__left">
                                                            <h3 class="reviews__comment--content__title h4">Richard Smith</h3>
                                                            <ul class="rating reviews__comment--rating d-flex">
                                                                <li class="rating__list">
                                                                    <span class="rating__list--icon">
                                                                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                                            <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <span class="reviews__comment--content__date">February 18, 2022</span>
                                                    </div>
                                                    <p class="reviews__comment--content__desc">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eos ex repellat officiis neque. Veniam, rem nesciunt. Assumenda distinctio, autem error repellat eveniet ratione dolor facilis accusantium amet pariatur, non eius!</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="writereview" class="reviews__comment--reply__area">
                                            <form action="#">
                                                <h3 class="reviews__comment--reply__title mb-15">Add a review </h3>
                                                <div class="reviews__ratting d-flex align-items-center mb-20">
                                                    <ul class="rating d-flex">
                                                        <li class="rating__list">
                                                            <span class="rating__list--icon">
                                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                        </li>
                                                        <li class="rating__list">
                                                            <span class="rating__list--icon">
                                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                        </li>
                                                        <li class="rating__list">
                                                            <span class="rating__list--icon">
                                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                        </li>
                                                        <li class="rating__list">
                                                            <span class="rating__list--icon">
                                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                        </li>
                                                        <li class="rating__list">
                                                            <span class="rating__list--icon">
                                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 mb-10">
                                                        <textarea class="reviews__comment--reply__textarea" placeholder="Your Comments...."></textarea>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 mb-15">
                                                        <label>
                                                            <input class="reviews__comment--reply__input" placeholder="Your Name...." type="text">
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 mb-15">
                                                        <label>
                                                            <input class="reviews__comment--reply__input" placeholder="Your Email...." type="email">
                                                        </label>
                                                    </div>
                                                </div>
                                                <button class="reviews__comment--btn text-white primary__btn" data-hover="Submit" type="submit">SUBMIT</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div id="information" class="tab_pane">
                                    <div class="product__tab--conten">
                                        <div class="product__tab--content__step mb-30">
                                            <h2 class="product__tab--content__title h4 mb-10">Nam provident sequi</h2>
                                            <p class="product__tab--content__desc">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam provident sequi, nemo sapiente culpa nostrum rem eum perferendis quibusdam, magnam a vitae corporis! Magnam enim modi, illo harum suscipit tempore aut dolore doloribus deserunt voluptatum illum, est porro? Ducimus dolore accusamus impedit ipsum maiores, ea iusto temporibus numquam eaque mollitia fugiat laborum dolor tempora eligendi voluptatem quis necessitatibus nam ab?</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End product details tab section -->

    </main>

</x-ecommerce-app-layout>
