<x-app-layout>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-4 md:mb-0">
                Product Management
            </h1>
            <button
                x-data=""
                x-on:click="$dispatch('open-modal', 'add-product-modal')"
                class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-white rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Add New Product
            </button>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 animate-fade-in-right">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                        <tr>
                            <th class="px-6 py-4 text-gray-600 dark:text-gray-300 font-semibold tracking-wider">Product</th>
                            <th class="px-6 py-4 text-gray-600 dark:text-gray-300 font-semibold tracking-wider">Price</th>
                            <th class="px-6 py-4 text-gray-600 dark:text-gray-300 font-semibold tracking-wider">Category</th>
                            <th class="px-6 py-4 text-gray-600 dark:text-gray-300 font-semibold tracking-wider">Stock</th>
                            <th class="px-6 py-4 text-gray-600 dark:text-gray-300 font-semibold tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @foreach($products as $product)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $product->name }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                    ${{ number_format($product->price, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                        {{ $product->category == 'Electronics' ? 'bg-blue-100 text-blue-800' :
                                           ($product->category == 'Clothing' ? 'bg-purple-100 text-purple-800' :
                                           'bg-gray-100 text-gray-800') }}">
                                        {{ $product->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($product->stock_quantity !== null)
                                        <div class="flex items-center">
                                            <span class="w-3 h-3 rounded-full mr-2
                                                {{ $product->stock_quantity > 10 ? 'bg-green-500' :
                                                   ($product->stock_quantity > 0 ? 'bg-yellow-500' : 'bg-red-500') }}">
                                            </span>
                                            {{ $product->stock_quantity }}
                                            @if($product->stock_quantity <= 5)
                                                <span class="ml-2 text-xs text-red-500 font-medium">Low Stock</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400">Not Tracked</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-3">
                                    <a href="{{ route('products.show', $product->id) }}"
           class="text-blue-600 hover:text-blue-900 transition-colors"
           title="View Product">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 3c-5 0-9 4.5-9 7s4 7 9 7 9-4.5 9-7-4-7-9-7zm0 12c-3.3 0-6-2.7-6-5s2.7-5 6-5 6 2.7 6 5-2.7 5-6 5zm0-9a4 4 0 110 8 4 4 0 010-8zm0 2a2 2 0 100 4 2 2 0 000-4z" />
            </svg>
        </a>
                                        <button
                                            x-data=""
                                            x-on:click="$dispatch('open-modal', 'edit-product-{{ $product->id }}')"
                                            class="text-indigo-600 hover:text-indigo-900 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </button>
                                        <button
                                            x-data=""
                                            x-on:click="$dispatch('open-modal', 'delete-product-{{ $product->id }}')"
                                            class="text-red-600 hover:text-red-900 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>

    <!-- Add Product Modal -->
    <x-modal name="add-product-modal" maxWidth="2xl">
        <form action="{{ route('products.store') }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Add New Product</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Name</label>
                        <input type="text" name="name" required class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price</label>
                        <input type="number" step="0.01" name="price" required class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                        <input type="text" name="category" required class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Stock Quantity (Optional)</label>
                        <input type="number" name="stock_quantity" min="0" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                </div>
                <div class="flex justify-end space-x-4 mt-6">
                    <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                    <x-primary-button type="submit">Save Product</x-primary-button>
                </div>
            </div>
        </form>
    </x-modal>

    <!-- Edit Product Modals -->
    @foreach($products as $product)
        <x-modal name="edit-product-{{ $product->id }}" maxWidth="2xl">
            <form action="{{ route('products.update', $product->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Edit Product</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Name</label>
                            <input type="text" name="name" value="{{ $product->name }}" required class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price</label>
                            <input type="number" step="0.01" name="price" value="{{ $product->price }}" required class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                            <input type="text" name="category" value="{{ $product->category }}" required class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Stock Quantity (Optional)</label>
                            <input type="number" name="stock_quantity" value="{{ $product->stock_quantity }}" min="0" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                    </div>
                    <div class="flex justify-end space-x-4 mt-6">
                        <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                        <x-primary-button type="submit">Update Product</x-primary-button>
                    </div>

                </div>
            </form>
        </x-modal>

        <!-- Delete Product Modal -->
        <x-modal name="delete-product-{{ $product->id }}" maxWidth="md">
            <div class="p-6 text-center">
                <div class="mb-5 flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 011 1v3a1 1 0 11-2 0V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                </div>

                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                    Are you sure you want to delete
                    <span class="font-bold text-gray-800 dark:text-white">"{{ $product->name }}"</span>?
                </h3>
                <div class="flex justify-center space-x-4">
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Yes, Delete
                        </button>
                        <x-secondary-button x-on:click="$dispatch('close')">
                            Cancel
                        </x-secondary-button>
                    </form>
                </div>
            </div>
        </x-modal>
    @endforeach
</x-app-layout>

<style>
    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    .animate-fade-in-right {
        animation: fadeInRight 0.5s ease-out;
    }
</style>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('productModal', () => ({
            isOpen: false,
            open() {
                this.isOpen = true;
            },
            close() {
                this.isOpen = false;
            }
        }))
    });
</script>
