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
                            <span class="badge">0</span>
                            <span class="icon-text">Wishlist</span>
                        </a>
                    </div>
                    <div class="icon-item">
                        <a href="/cart" class="icon-link cart-icon">
                            <i class="bi bi-bag"></i>
                            <span class="badge">0</span>
                            <span class="icon-text">Cart</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* Main Header */
    .main-header {
        background: linear-gradient(90deg, rgb(255, 255, 255), rgb(255, 255, 255));
        backdrop-filter: blur(8px);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 0;
        z-index: 1050;
    }

    /* Navbar Styles */
    .navbar {
        padding: 12px 0;
    }

    .logo {
        height: 50px;
        width: auto;
        transition: transform 0.3s ease;
    }

    .logo:hover {
        transform: scale(1.1);
    }

    /* Search Box */
    .search-box {
        position: relative;
        max-width: 330px;
        flex-grow: 1;
    }

    .search-icon {
        position: absolute;
        left: -15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        z-index: 1;
    }

    .search-input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border: 1px solid #e2e8f0;
        border-radius: 30px;
        background: #f1f5f9;
        transition: all 0.3s ease;
        font-size: 1.3rem;
    }

    .search-input:focus {
        background: #fff;
        border-color: #3b82f6;
        box-shadow: 0 0 5px rgba(59, 130, 246, 0.3);
    }

    .search-button {
        background-color: transparent;
        border: none;
        cursor: pointer;
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
    }

    .search-button .search-icon {
        font-size: 20px;
        color: #94a3b8;
    }

    .search-button:hover .search-icon {
        color: #3b82f6;
    }

    /* Navigation Links */
    .navbar-nav {
        gap: 10px;
    }

    .nav-link {
        font-weight: 500;
        color: #475569;
        height: auto;
        padding: 12px 25px;
        border-radius: 20px;
        margin: 0 5px;
        transition: background 0.3s, color 0.3s;
    }

    .nav-link:hover {
        color: #3b82f6;
        background: #e0f2fe;
    }

    .nav-link.active {
        color: #fff;
        width: 75px;
        padding: 12px 15px;
        border-radius: 100px;
        text-align: center;
        background: #3b82f6;
    }

    /* Icons */
    .nav-icons {
        display: flex;
        gap: 20px;
        align-items: center;
    }

    .icon-item {
        position: relative;
    }

    .icon-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        color: #475569;
        transition: transform 0.3s ease;
    }

    .icon-link:hover {
        color: #3b82f6;
        transform: translateY(-2px);
    }

    .icon-link i {
        font-size: 1.5rem;
    }

    .badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #3b82f6;
        color: white;
        font-size: 0.7rem;
        padding: 2px 5px;
        border-radius: 50%;
        min-width: 16px;
        height: 16px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Responsive Design */
    @media (max-width: 991px) {
        .navbar-nav {
            flex-direction: column;
            margin: 15px 0;
        }

        .search-box {
            max-width: 100%;
            margin-bottom: 15px;
        }

        .nav-icons {
            justify-content: space-between;
            width: 100%;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
        }
    }

    @media (max-width: 576px) {
        .logo {
            height: 40px;
        }

        .search-input {
            font-size: 1.1rem;
        }
    }
</style>

<script>
    // Function to perform dynamic search
    function searchProducts() {
        var searchQuery = document.getElementById('searchInput').value;
        if (searchQuery.length >= 3) { // Trigger search only when 3 or more characters are typed
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/search-api?query=" + encodeURIComponent(searchQuery), true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    // Display search results
                    document.getElementById('searchResults').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        } else {
            document.getElementById('searchResults').innerHTML = ''; // Clear results if search query is too short
        }
    }

    // Add active class dynamically to navbar links
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.nav-link');
        const currentUrl = window.location.pathname;

        navLinks.forEach(link => {
            const linkUrl = new URL(link.href).pathname; // Extract pathname
            if (currentUrl === linkUrl) {
                navLinks.forEach(link => link.classList.remove('active')); // Remove active from all
                link.classList.add('active'); // Add active to the current link
            }
        });
    });
</script>