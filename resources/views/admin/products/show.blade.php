<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ $product->name }}</h1>
            <p class="text-gray-700 dark:text-gray-300">Price: ${{ number_format($product->price, 2) }}</p>
            <p class="text-gray-700 dark:text-gray-300">Category: {{ $product->category }}</p>
            <p class="text-gray-700 dark:text-gray-300">Stock: {{ $product->stock_quantity ?? 'Not Tracked' }}</p>
            <p class="mt-4 text-gray-700 dark:text-gray-300">{{ $product->description }}</p>
        </div>
    </div>
</x-app-layout>
