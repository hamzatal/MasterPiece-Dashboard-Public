<x-app-layout>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-gradient-to-br from-indigo-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-2xl shadow-2xl p-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 space-y-4 md:space-y-0">
                <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">
                    Product Management
                </h1>
                <button
                    x-data=""
                    x-on:click="$dispatch('open-modal', 'add-product-modal')"
                    class="group flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 group-hover:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Add New Product
                </button>
            </div>

            @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl animate-fade-in-right">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <tr>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-300 font-bold">Product</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-300 font-bold">Price</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-300 font-bold">Category</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-300 font-bold">Stock</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-300 font-bold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            @foreach($products as $product)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 group">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white group-hover:text-indigo-600">
                                    {{ $product->name }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300 font-semibold">
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
                                        @if($product->stock_quantity == 0)
                                        <span class="ml-2 text-xs text-red-500 font-medium">Out of Stock</span>
                                        @elseif($product->stock_quantity <= 5)
                                            <span class="ml-2 text-xs text-yellow-500 font-medium">Low Stock</span>
                                            @endif
                                    </div>
                                    @else
                                    <span class="text-gray-400">Not Tracked</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end space-x-3">
                                        <a href="{{ route('products.show', $product->id) }}"
                                            class="text-blue-500 hover:text-blue-700 transition-colors p-2 rounded-full hover:bg-blue-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        <button
                                            x-data=""
                                            x-on:click="$dispatch('open-modal', 'edit-product-{{ $product->id }}')"
                                            class="text-indigo-500 hover:text-indigo-700 transition-colors p-2 rounded-full hover:bg-indigo-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </button>
                                        <button
                                            x-data=""
                                            x-on:click="$dispatch('open-modal', 'delete-product-{{ $product->id }}')"
                                            class="text-red-500 hover:text-red-700 transition-colors p-2 rounded-full hover:bg-red-50">
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
