<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevStore - Modern E-Commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Navigation (Previous implementation remains the same) -->
    <!-- ... (previous nav code) ... -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <svg class="h-8 w-auto sm:h-10 text-indigo-600" fill="currentColor" viewBox="0 0 50 50">
                            <path d="M25 3L3 13l22 10 22-10-22-10z"/>
                            <path d="M3 26l22 10 22-10M3 37l22 10 22-10"/>
                        </svg>
                        <span class="ml-2 text-2xl font-bold text-gray-900">DevStore</span>
                    </a>
                </div>

                <!-- Main Navigation Links -->
                <div class="hidden md:flex space-x-6">
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition duration-300">Products</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition duration-300">Categories</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition duration-300">Deals</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition duration-300">About</a>
                </div>

                <!-- Right Side Icons -->
                <div class="flex items-center space-x-4">
                    <!-- Search Icon -->
                    <button class="text-gray-600 hover:text-indigo-600 transition duration-300">
                        <i class="fas fa-search"></i>
                    </button>

                    <!-- Cart Icon -->
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition duration-300 relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
                    </a>

                    <!-- Authentication Dropdown -->
                    @guest
                    <div class="relative">
                        <a href="{{ route('login') }}" class="bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 px-6 py-2.5 rounded-full flex items-center text-white font-semibold transition-all duration-300 ease-in-out transform hover:scale-105 shadow-lg">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Log in / Register
                        </a>
                    </div>
                    @endguest

                    @auth
                    <div x-data="{ isOpen: false }" class="relative">
                        <button
                            @click="isOpen = !isOpen"
                            @click.away="isOpen = false"
                            class="flex items-center space-x-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-4 py-2 rounded-full hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 ease-in-out transform hover:scale-105 shadow-lg"
                        >
                            <img src="{{ Auth::user()->profile_picture ?? '/default-avatar.png' }}" alt="Profile" class="w-8 h-8 rounded-full mr-2 border-2 border-white">
                            <span class="font-semibold">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div
                            x-show="isOpen"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-90"
                            class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-2xl border border-gray-200 z-50 overflow-hidden"
                        >
                            <div class="px-4 py-3 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-200">
                                <p class="text-sm text-gray-600">Signed in as</p>
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->email }}</p>
                            </div>

                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 transition duration-200 flex items-center">
                                    <i class="fas fa-user mr-3 text-indigo-500"></i>
                                    My Profile
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 transition duration-200 flex items-center">
                                    <i class="fas fa-shopping-bag mr-3 text-indigo-500"></i>
                                    My Orders
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 transition duration-200 flex items-center">
                                    <i class="fas fa-heart mr-3 text-indigo-500"></i>
                                    Wishlist
                                </a>
                            </div>

                            <div class="border-t border-gray-200">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition duration-200 flex items-center"
                                    >
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>
        </div>

    <!-- Main Content Area -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 space-y-12">
        <!-- Hero Section (Previous implementation) -->
        <section class="grid md:grid-cols-2 gap-8 items-center bg-gradient-to-r from-indigo-100 to-purple-100 rounded-2xl p-8 shadow-lg">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Discover the Latest Tech Gear</h1>
                <p class="text-xl text-gray-600 mb-6">Explore cutting-edge devices and accessories for developers and tech enthusiasts.</p>
                <a href="#" class="inline-block bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-8 py-3 rounded-full hover:from-indigo-600 hover:to-purple-700 transition duration-300 transform hover:scale-105 shadow-lg">
                    Shop Now
                </a>
            </div>
            <div>
                <img src="/api/placeholder/600/400" alt="Tech Gear" class="rounded-xl shadow-2xl">
            </div>
        </section>

        <!-- Featured Categories -->
        <section>
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">Shop by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <div class="p-6 text-center">
                        <i class="fas fa-laptop text-5xl text-indigo-600 mb-4"></i>
                        <h3 class="font-semibold text-lg text-gray-800">Laptops</h3>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <div class="p-6 text-center">
                        <i class="fas fa-mobile-alt text-5xl text-purple-600 mb-4"></i>
                        <h3 class="font-semibold text-lg text-gray-800">Smartphones</h3>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <div class="p-6 text-center">
                        <i class="fas fa-headphones text-5xl text-green-600 mb-4"></i>
                        <h3 class="font-semibold text-lg text-gray-800">Accessories</h3>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <div class="p-6 text-center">
                        <i class="fas fa-keyboard text-5xl text-red-600 mb-4"></i>
                        <h3 class="font-semibold text-lg text-gray-800">Peripherals</h3>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Products -->
        <section>
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">Featured Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <img src="/api/placeholder/400/300" alt="Product" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2 text-gray-900">Pro Developer Laptop</h3>
                        <p class="text-gray-600 mb-4">High-performance laptop for coding and design</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-indigo-600">$1,299.99</span>
                            <button class="bg-indigo-500 text-white px-4 py-2 rounded-full hover:bg-indigo-600 transition duration-300">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <img src="/api/placeholder/400/300" alt="Product" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2 text-gray-900">Noise-Cancelling Headphones</h3>
                        <p class="text-gray-600 mb-4">Premium audio for work and play</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-indigo-600">$249.99</span>
                            <button class="bg-indigo-500 text-white px-4 py-2 rounded-full hover:bg-indigo-600 transition duration-300">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <img src="/api/placeholder/400/300" alt="Product" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2 text-gray-900">Mechanical Keyboard</h3>
                        <p class="text-gray-600 mb-4">High-precision typing experience</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-indigo-600">$129.99</span>
                            <button class="bg-indigo-500 text-white px-4 py-2 rounded-full hover:bg-indigo-600 transition duration-300">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Special Deals -->
        <section class="bg-gradient-to-r from-purple-100 to-indigo-100 rounded-2xl p-8 shadow-lg">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Hot Deals This Week</h2>
                <p class="text-xl text-gray-600 mb-6">Limited time offers on top tech products</p>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl p-6 shadow-md">
                        <h3 class="text-xl font-bold text-indigo-600 mb-2">Up to 30% Off</h3>
                        <p class="text-gray-700">Selected Laptops</p>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-md">
                        <h3 class="text-xl font-bold text-purple-600 mb-2">Buy 1 Get 1</h3>
                        <p class="text-gray-700">Accessories</p>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-md">
                        <h3 class="text-xl font-bold text-green-600 mb-2">Extra 20% Off</h3>
                        <p class="text-gray-700">Student Discounts</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Newsletter Signup -->
        <section class="bg-white rounded-2xl shadow-lg p-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Stay Updated with DevStore</h2>
            <p class="text-xl text-gray-600 mb-6">Subscribe to our newsletter for exclusive deals and tech updates</p>
            <form class="max-w-xl mx-auto flex">
                <input
                    type="email"
                    placeholder="Enter your email address"
                    class="flex-grow px-4 py-3 border border-gray-300 rounded-l-full focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                />
                <button
                    type="submit"
                    class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-r-full hover:from-indigo-600 hover:to-purple-700 transition duration-300"
                >
                    Subscribe
                </button>
            </form>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-4 gap-8">
            <div>
                <h3 class="font-bold text-xl mb-4">DevStore</h3>
                <p class="text-gray-400">Your one-stop shop for cutting-edge tech and developer gear.</p>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white">Products</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Categories</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Deals</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Customer Service</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white">Contact Us</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Shipping</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Returns</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Connect With Us</h4>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
