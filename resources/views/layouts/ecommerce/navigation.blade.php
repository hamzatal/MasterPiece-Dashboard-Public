<!-- Enhanced Header HTML -->
<header class="main-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="/home">
                <img src="assets/img/logo/dev.png" alt="logo" class="logo">
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Search Bar -->
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Search products..." id="searchInput" onkeyup="searchProducts()">
                    <button class="search-button" onclick="searchProducts()">
                        <i class="bi bi-search search-icon"></i>
                    </button>
                </div>

                <!-- Dynamic Search Results -->
                <div id="searchResults"></div>

                <!-- Navigation Menu -->
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/shop">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about-us">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact-us">Contact</a>
                    </li>
                </ul>

                <!-- Right Icons -->
                <div class="nav-icons">
                    <div class="icon-item">
                        <li class="header__menu--items header__minicart--items">
                            <a class="header__account--btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" -user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span class="visually-hidden">My account</span>
                                <svg class="menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12" height="7.41" viewBox="0 0 12 7.41">
                                    <path d="M16.59,8.59,12,13.17,7.41,8.59,6,10l6,6,6-6Z" transform="translate(-6 -8.59)" fill="currentColor" opacity="0.7" />
                                </svg>
                            </a>
                            <ul class="header__sub--menu" style="left: -125px; width: 175px;">
                                <li class="header__sub--menu__items">
                                    <a href="{{ route('profile.edit') }}" class="header__sub--menu__link">My Account</a>
                                </li>
                                <li class="header__sub--menu__items">
                                    <a href="{{ route('profile.edit') }}" class="header__sub--menu__link">My Orders</a>
                                </li>
                                <li class="header__sub--menu__items">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="header__sub--menu__link">
                                            Logout
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </div>
                    <div class="icon-item">
                        <a href="/wishlist" class="icon-link">
                            <i class="bi bi-heart"></i>
                            <span class="badge">{{ $wishlistCount }}</span>
                            <span class="icon-text">Wishlist</span>
                        </a>
                    </div>
                    <div class="icon-item">
                        <a href="/cart" class="icon-link cart-icon">
                            <i class="bi bi-bag"></i>
                            <span class="icon-text">Cart</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </nav>
</header>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="css/navbar.js">
<link rel="javascript" href="js/navbar.js">
