<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-6">
            <!-- Product Title -->
            <div class="flex items-center mb-4">
                <i class="fas fa-box-open text-blue-500 mr-3 text-2xl"></i>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $product->name ?? 'Unnamed Product' }}
                </h1>
            </div>

            <!-- Product Details -->
            <div class="space-y-3">
                <!-- Price -->
                <div class="flex items-center text-gray-700 dark:text-gray-300">
                    <i class="fas fa-dollar-sign text-green-500 mr-2"></i>
                    <span>Price: ${{ number_format($product->price ?? 0, 2) }}</span>
                </div>

                <!-- Category -->
                <div class="flex items-center text-gray-700 dark:text-gray-300">
                    <i class="fas fa-tags text-purple-500 mr-2"></i>
                    <span>Category: {{ $product->category->name ?? 'Uncategorized' }}</span>
                </div>

                <!-- Stock Quantity -->
                <div class="flex items-center text-gray-700 dark:text-gray-300">
                    <i class="fas fa-warehouse text-indigo-500 mr-2"></i>
                    <span>Stock: {{ $product->stock_quantity ?? 'Not Tracked' }}</span>
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6 flex items-start">
                <i class="fas fa-info-circle text-gray-500 mr-2 mt-1"></i>
                <p class="text-gray-700 dark:text-gray-300">
                    {{ $product->description ?? 'No description available.' }}
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
