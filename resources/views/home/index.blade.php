<x-ecommerce-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>



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
                    <img src="/storage/products/t4.jpeg" alt="Tech Gear" class="rounded-xl shadow-2xl">
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
                        <img src="/storage/products/t4.jpeg" alt="Products" class="w-full h-64 object-cover">
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
                        <img src="/storage/products/so.jpg" alt="Product" class="w-full h-64 object-cover">
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
                        <img src="/storage/products/t3.jpeg" alt="Product" class="w-full h-64 object-cover">
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
                        class="flex-grow px-4 py-3 border border-gray-300 rounded-l-full focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    <button
                        type="submit"
                        class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-r-full hover:from-indigo-600 hover:to-purple-700 transition duration-300">
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

</x-ecommerce-app-layout>
