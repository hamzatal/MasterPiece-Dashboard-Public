<x-admin-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section (Remains the same) -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-blue-500 bg-clip-text text-transparent">
                    Product Management
                </h1>
                <button
                    x-data=""
                    x-on:click="$store.productForm.toggleForm()"
                    class="mt-4 md:mt-0 group flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-500 hover:from-purple-700 hover:to-blue-600 text-white rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Product
                </button>
            </div>

            <!-- Success Message (Remains the same) -->
            @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/50 border-l-4 border-green-500 p-4 rounded-r-xl animate-fade-in-down">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-green-800 dark:text-green-200">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <!-- Inline Create/Edit Form -->
            <div x-data="{
                show: false,
                image: null,
                imagePreview: null,
                isEditing: false,
                editProduct: null,
                handleImageUpload(event) {
                    const file = event.target.files[0];
                    this.image = file;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.imagePreview = e.target.result;
                    };
                    if (file) {
                        reader.readAsDataURL(file);
                    }
                },
                openEditForm(product) {
                    this.isEditing = true;
                    this.editProduct = product;
                    this.$store.productForm.toggleForm();
                    this.$nextTick(() => {
                        document.querySelector('input[name=name]').value = product.name;
                        document.querySelector('input[name=price]').value = product.price;
                        document.querySelector('select[name=category_id]').value = product.category_id;
                        document.querySelector('input[name=stock_quantity]').value = product.stock_quantity;
                        this.imagePreview = product.image ? '{{ Storage::url('') }}' + product.image : null;
                    });
                }
            }"
                x-show="$store.productForm.isOpen"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-4"
                class="mb-8 bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 border border-gray-100 dark:border-gray-700">
                <form
                    x-bind:action="isEditing ? '{{ route('products.update', ['product' => ':id']) }}'.replace(':id', editProduct ? editProduct.id : '') : '{{ route('products.store') }}'"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="_method" x-bind:value="isEditing ? 'PUT' : 'POST'">

                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Image Upload Section (Remains largely the same) -->
                        <div class="w-full md:w-1/4">
                            <div class="relative aspect-square rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-gray-400 transition-colors">
                                <input type="file" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleImageUpload($event)">
                                <div class="absolute inset-0 flex flex-col items-center justify-center" x-show="!imagePreview">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Click to upload image</p>
                                </div>
                                <img x-show="imagePreview" :src="imagePreview" class="absolute inset-0 w-full h-full object-cover rounded-xl">
                            </div>
                        </div>
                        <div
                            x-each="[1, 2, 3]"
                            class="relative aspect-square rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-gray-400 transition-colors">
                            <input
                                type="file"
                                :name="'image_' + $each.index"
                                accept="image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                @change="handleImageUpload($event, $each.index)">
                            <div
                                class="absolute inset-0 flex flex-col items-center justify-center"
                                x-show="!imagePreviews[$each.index]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Click to upload image</p>
                            </div>
                            <img
                                x-show="imagePreviews[$each.index]"
                                :src="imagePreviews[$each.index]"
                                class="absolute inset-0 w-full h-full object-cover rounded-xl">
                            <button
                                x-show="imagePreviews[$each.index]"
                                @click="removeImage($each.index)"
                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 z-20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <!-- Form Fields -->
                        <div class="w-full md:w-3/4 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Name</label>
                                <input type="text" name="name" required class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-purple-500 focus:border-purple-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price</label>
                                <input type="number" step="0.01" name="price" required class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-purple-500 focus:border-purple-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                                <select name="category_id" required class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-purple-500 focus:border-purple-500">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Stock Quantity</label>
                                <input type="number" name="stock_quantity" min="0" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-purple-500 focus:border-purple-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                                <textarea
                                    name="description"
                                    rows="4"
                                    class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-purple-500 focus:border-purple-500"
                                    placeholder="Enter product description"></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        <button type="button" @click="$store.productForm.toggleForm(); isEditing = false" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-500 hover:from-purple-700 hover:to-blue-600 text-white rounded-lg transition-colors">
                            <span x-text="isEditing ? 'Update Product' : 'Save Product'"></span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Products Table -->
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
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0 w-12 h-12">
                                            @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover">
                                            @else
                                            <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $product->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">#{{ $product->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-900 dark:text-white font-medium">${{ number_format($product->price, 2) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                        {{ $product->category->name == 'Electronics' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' :
                                           ($product->category->name == 'Clothing' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' :
                                           'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300') }}">
                                        {{ $product->category->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <span class="w-2 h-2 rounded-full mr-2
                                            {{ $product->stock_quantity > 10 ? 'bg-green-500' :
                                               ($product->stock_quantity > 0 ? 'bg-yellow-500' : 'bg-red-500') }}">
                                        </span>
                                        <span class="font-medium {{ $product->stock_quantity > 10 ? 'text-green-600 dark:text-green-400' :
                                               ($product->stock_quantity > 0 ? 'bg-yellow-500' : 'bg-red-500') }}">
                                        </span>
                                        <span class="font-medium {{ $product->stock_quantity > 10 ? 'text-green-600 dark:text-green-400' :
                                                                   ($product->stock_quantity > 0 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                                            {{ $product->stock_quantity }}
                                        </span>
                                        @if($product->stock_quantity == 0)
                                        <span class="ml-2 text-xs text-red-500 font-medium">Out of Stock</span>
                                        @elseif($product->stock_quantity <= 5)
                                            <span class="ml-2 text-xs text-yellow-500 font-medium">Low Stock</span>
                                            @endif
                                    </div>
                                </td>
                                <!-- In the table actions section, modify the buttons -->
                                <td class="px-6 py-4">
                                    <div class="flex justify-end space-x-3">
                                        <a href="{{ route('products.show', $product->id) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-blue-600 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
                                            Show
                                        </a>

                                        <!-- Edit Button -->
                                        <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-green-600 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd" d="M2 16V6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2z" clip-rule="evenodd" />
                                            </svg>
                                            Edit
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this user?')" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-red-600 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
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
    </div>

    <!-- Alpine.js Store for Form State -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('productForm', {
                isOpen: false,
                toggleForm() {
                    this.isOpen = !this.isOpen;
                }
            });
        });
    </script>

    <style>
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fadeInDown 0.3s ease-out;
        }
    </style>
</x-admin-app-layout>
