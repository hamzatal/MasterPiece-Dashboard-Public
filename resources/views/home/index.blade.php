<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevStore - Programmer's Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <header class="bg-indigo-800 text-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-code text-3xl mr-3"></i>
                <h1 class="text-2xl font-bold">DevStore</h1>
            </div>
            <nav class="flex space-x-6">
                <a href="#" class="hover:text-indigo-200 flex items-center">
                    <i class="fas fa-laptop mr-2"></i>Hardware
                </a>
                <a href="#" class="hover:text-indigo-200 flex items-center">
                    <i class="fas fa-book mr-2"></i>Books
                </a>
                <a href="#" class="hover:text-indigo-200 flex items-center">
                    <i class="fas fa-tools mr-2"></i>Tools
                </a>
            </nav>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search products..." class="pl-10 pr-4 py-2 rounded-full text-black">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-500"></i>
                </div>
                <button class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded-full flex items-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </button>
                <a href="#" class="text-white">
                    <i class="fas fa-shopping-cart text-xl"></i>
                </a>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg p-8 mb-12 flex items-center">
            <div class="w-2/3">
                <h2 class="text-4xl font-bold mb-4">Level Up Your Dev Gear</h2>
                <p class="text-xl mb-6">Exclusive collection for programmers, developers, and tech enthusiasts</p>
                <button class="bg-yellow-500 text-black px-6 py-3 rounded-full hover:bg-yellow-600 flex items-center">
                    <i class="fas fa-shopping-bag mr-2"></i>Shop Now
                </button>
            </div>
            <div class="w-1/3">
                <img src="/api/placeholder/300/300" alt="Developer Setup" class="rounded-lg">
            </div>
        </section>

        <section>
            <h3 class="text-2xl font-bold mb-6">Featured Products</h3>
            <div class="grid grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow-md p-4 text-center">
                    <img src="/api/placeholder/300/300" alt="Mechanical Keyboard" class="mx-auto mb-4 rounded-lg">
                    <h4 class="font-bold text-lg">Pro Mechanical Keyboard</h4>
                    <div class="flex justify-center items-center my-2">
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="far fa-star text-yellow-500"></i>
                    </div>
                    <p class="text-indigo-600 font-semibold">$149.99</p>
                    <button class="mt-4 bg-indigo-500 text-white px-4 py-2 rounded-full hover:bg-indigo-600">
                        <i class="fas fa-cart-plus mr-2"></i>Add to Cart
                    </button>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4 text-center">
                    <img src="/api/placeholder/300/300" alt="Ergonomic Mouse" class="mx-auto mb-4 rounded-lg">
                    <h4 class="font-bold text-lg">Ergonomic Developer Mouse</h4>
                    <div class="flex justify-center items-center my-2">
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star-half-alt text-yellow-500"></i>
                    </div>
                    <p class="text-indigo-600 font-semibold">$89.99</p>
                    <button class="mt-4 bg-indigo-500 text-white px-4 py-2 rounded-full hover:bg-indigo-600">
                        <i class="fas fa-cart-plus mr-2"></i>Add to Cart
                    </button>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4 text-center">
                    <img src="/api/placeholder/300/300" alt="Noise Cancelling Headphones" class="mx-auto mb-4 rounded-lg">
                    <h4 class="font-bold text-lg">Pro Noise Cancelling Headphones</h4>
                    <div class="flex justify-center items-center my-2">
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="far fa-star text-yellow-500"></i>
                    </div>
                    <p class="text-indigo-600 font-semibold">$199.99</p>
                    <button class="mt-4 bg-indigo-500 text-white px-4 py-2 rounded-full hover:bg-indigo-600">
                        <i class="fas fa-cart-plus mr-2"></i>Add to Cart
                    </button>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto px-4 grid grid-cols-3 gap-6">
            <div>
                <h4 class="font-bold mb-4">Quick Links</h4>
                <ul>
                    <li><a href="#" class="hover:text-indigo-300"><i class="fas fa-chevron-right mr-2"></i>About Us</a></li>
                    <li><a href="#" class="hover:text-indigo-300"><i class="fas fa-chevron-right mr-2"></i>Contact</a></li>
                    <li><a href="#" class="hover:text-indigo-300"><i class="fas fa-chevron-right mr-2"></i>FAQ</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Connect With Us</h4>
                <div class="flex space-x-4">
                    <a href="#" class="text-2xl hover:text-indigo-300"><i class="fab fa-github"></i></a>
                    <a href="#" class="text-2xl hover:text-indigo-300"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-2xl hover:text-indigo-300"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div>
                <h4 class="font-bold mb-4">Newsletter</h4>
                <p class="mb-4">Stay updated with dev deals</p>
                <div class="flex">
                    <input type="email" placeholder="Your email" class="px-4 py-2 rounded-l text-black w-full">
                    <button class="bg-green-500 text-white px-4 py-2 rounded-r hover:bg-green-600">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
