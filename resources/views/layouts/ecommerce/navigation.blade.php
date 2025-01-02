<!-- Header  -->
<header class="nx-main-header">
    <nav class="nx-navbar">
        <div class="nx-container">
            <!-- Logo -->
            <a class="nx-brand" href="/home">
                <img src="assets/img/logo/SyntaxStore.png" alt="logo" class="nx-logo">
            </a>

            <!-- Mobile Toggle -->
            <button class="nx-mobile-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#nxContent">
                <i class="bi bi-list"></i>
            </button>

            <div class="nx-collapse" id="nxContent">
                <!-- Search Bar -->
                <div class="nx-search-wrapper">
                    <div class="nx-search-container">
                        <i class="bi bi-search nx-search-icon"></i>
                        <input type="text" class="nx-search-input" placeholder="Search products..." id="searchInput">
                        <button class="nx-search-clear">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <div class="nx-search-results" id="searchResults"></div>
                </div>

                <!-- Navigation Menu -->
                <ul class="nx-nav-list">
                    <li class="nx-nav-item">
                        <a class="nx-nav-link" href="/home">
                            <i class="bi bi-house"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="nx-nav-item">
                        <a class="nx-nav-link" href="/shop">
                            <i class="bi bi-shop"></i>
                            <span>Shop</span>
                        </a>
                    </li>
                    <li class="nx-nav-item">
                        <a class="nx-nav-link" href="/about-us">
                            <i class="bi bi-info-circle"></i>
                            <span>About</span>
                        </a>
                    </li>
                    <li class="nx-nav-item">
                        <a class="nx-nav-link" href="/contact-us">
                            <i class="bi bi-envelope"></i>
                            <span>Contact</span>
                        </a>
                    </li>
                </ul>

                <!-- Right Icons -->
                <div class="nx-actions">

                    <a href="/wishlist" class="nx-action-btn">
                        <i class="bi bi-heart"></i>
                        <span class="nx-badge">{{ $wishlistCount }}</span>
                        <span>Wishlist</span>
                    </a>
                    <a href="/cart" class="nx-action-btn">
                        <i class="bi bi-bag"></i>
                        <span class="nx-badge">{{ $cartCount }}</span>
                        <span>Cart</span>
                    </a>
                    <div class="nx-action-item nx-account-dropdown">
                        <button class="nx-action-btn">
                            <i class="bi bi-person"></i>
                            <span>Account</span>
                        </button>
                        <ul class="nx-dropdown-menu">
                            <li>
                                <a href="{{ route('profile.edit') }}" class="nx-dropdown-link">
                                    <i class="bi bi-person-gear"></i>
                                    My Account
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('orders.confirmation') }}" class="nx-dropdown-link">
                                    <i class="bi bi-box"></i>
                                    My Orders
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="nx-dropdown-link">
                                        <i class="bi bi-box-arrow-right"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="css/navbar.css">
<link rel="javascript" href="js/navbar.js">
