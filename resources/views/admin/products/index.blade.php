<x-admin-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-blue-500 bg-clip-text text-transparent">
                            Product Management
                        </h1>
                        <p class="text-gray-500 dark:text-gray-400 mt-1">Manage your product inventory and details</p>
                    </div>
                </div>
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

            <!-- Success Message -->
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

            <!-- Create/Edit Form -->
            <div x-data="{
                show: false,
                image1Preview: null,
                image2Preview: null,
                image3Preview: null,
                isEditing: false,
                editProduct: null,
                errors: {},
                selectedSize: '',
                selectedColor: '',
                showCustomSizeInput: false,
                showCustomColorInput: false,
                handleImageUpload(event, imageNum) {
                    const file = event.target.files[0];
                    if (file) {
                        if (file.size > 2048576) { // 2MB limit
                            this.errors[`image${imageNum}`] = 'Image must be less than 2MB';
                            event.target.value = '';
                            return;
                        }
                        if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
                            this.errors[`image${imageNum}`] = 'Image must be in JPG, PNG, or GIF format';
                            event.target.value = '';
                            return;
                        }
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this[`image${imageNum}Preview`] = e.target.result;
                        };
                        reader.readAsDataURL(file);
                        this.errors[`image${imageNum}`] = null;
                    }
                },
                validateForm() {
                    this.errors = {};
                    let isValid = true;

                    // Name validation
                    const name = document.querySelector('input[name=name]').value;
                    if (!name || name.length < 3) {
                        this.errors.name = 'Product name must be at least 3 characters';
                        isValid = false;
                    }

                    // Original Price validation
                    const originalPrice = document.querySelector('input[name=original_price]').value;
                    if (!originalPrice || originalPrice <= 0) {
                        this.errors.original_price = 'Price must be greater than 0';
                        isValid = false;
                    }

                    // Category validation
                    const category = document.querySelector('select[name=category_id]').value;
                    if (!category) {
                        this.errors.category = 'Please select a category';
                        isValid = false;
                    }

                    return isValid;
                },
                openEditForm(product) {
                    this.isEditing = true;
                    this.editProduct = product;
                    this.$store.productForm.toggleForm();
                    this.$nextTick(() => {
                        document.querySelector('input[name=name]').value = product.name;
                        document.querySelector('input[name=original_price]').value = product.original_price;
                        document.querySelector('select[name=category_id]').value = product.category_id;
                        document.querySelector('input[name=stock_quantity]').value = product.stock_quantity;
                        document.querySelector('textarea[name=description]').value = product.description;
                        document.querySelector('select[name=size]').value = product.size;
                        document.querySelector('select[name=color]').value = product.color;
                        this.image1Preview = product.image1 ? '{{ Storage::url('') }}' + product.image1 : null;
                        this.image2Preview = product.image2 ? '{{ Storage::url('') }}' + product.image2 : null;
                        this.image3Preview = product.image3 ? '{{ Storage::url('') }}' + product.image3 : null;
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
                    @submit.prevent="if(validateForm()) $el.submit()"
                    class="space-y-6">
                    @csrf
                    <input type="hidden" name="_method" x-bind:value="isEditing ? 'PUT' : 'POST'">

                    <!-- Form Header -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white" x-text="isEditing ? 'Edit Product' : 'Add New Product'"></h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Fill in the information below to create a new product.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Product Details -->
                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="space-y-6">
                                <!-- Product Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product Name</label>
                                    <input
                                        type="text"
                                        name="name"
                                        class="mt-1 w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-purple-500 focus:border-purple-500"
                                        placeholder="Enter product name">
                                    <p class="text-xs text-red-500" x-text="errors.name" x-show="errors.name"></p>
                                </div>

                                <!-- Category -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                                    <select
                                        name="category_id"
                                        class="mt-1 w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-purple-500 focus:border-purple-500">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-red-500" x-text="errors.category" x-show="errors.category"></p>
                                </div>

                                <!-- Product Attributes -->
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Size -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Size</label>
                                        <select
                                            name="size"
                                            x-model="selectedSize"
                                            class="mt-1 w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-purple-500 focus:border-purple-500"
                                            @change="selectedSize === 'custom' ? showCustomSizeInput = true : showCustomSizeInput = false">
                                            <option value="">Select Size</option>
                                            <option value="S">Small (S)</option>
                                            <option value="M">Medium (M)</option>
                                            <option value="L">Large (L)</option>
                                            <option value="XL">Extra Large (XL)</option>
                                            <option value="40">40</option>
                                            <option value="41">41</option>
                                            <option value="42">42</option>
                                            <option value="43">43</option>
                                            <option value="44">44</option>
                                            <option value="45">45</option>
                                            <option value="custom">Custom Size</option>
                                        </select>
                                        <!-- Custom Size Input (Shows when "Custom" is selected) -->
                                        <input
                                            x-show="showCustomSizeInput"
                                            type="text"
                                            name="custom_size"
                                            placeholder="Enter custom size"
                                            class="mt-2 w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-purple-500 focus:border-purple-500">
                                    </div>

                                    <!-- Color -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
                                        <select
                                            name="color"
                                            x-model="selectedColor"
                                            class="mt-1 w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-purple-500 focus:border-purple-500"
                                            @change="selectedColor === 'custom' ? showCustomColorInput = true : showCustomColorInput = false">
                                            <option value="">Select Color</option>
                                            <option value="Black">Black</option>
                                            <option value="White">White</option>
                                            <option value="Red">Red</option>
                                            <option value="Blue">Blue</option>
                                            <option value="Green">Green</option>
                                            <option value="Yellow">Yellow</option>
                                            <option value="Gray">Gray</option>
                                            <option value="custom">Custom Color</option>
                                        </select>
                                        <!-- Custom Color Input (Shows when "Custom" is selected) -->
                                        <input
                                            x-show="showCustomColorInput"
                                            type="text"
                                            name="custom_color"
                                            placeholder="Enter custom color"
                                            class="mt-2 w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-purple-500 focus:border-purple-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing and Stock -->
                            <div class="space-y-6">
                                <!-- Price -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                                    <div class="relative mt-1">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-gray-400">JD</span>
                                        </div>
                                        <input
                                            type="number"
                                            step="0.001"
                                            name="original_price"
                                            class="pl-8 w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-purple-500 focus:border-purple-500"
                                            placeholder="0.000">
                                    </div>
                                    <p class="text-xs text-red-500" x-text="errors.original_price" x-show="errors.original_price"></p>
                                </div>

                                <!-- Stock Quantity -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock Quantity</label>
                                    <input
                                        type="number"
                                        name="stock_quantity"
                                        min="0"
                                        class="mt-1 w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-purple-500 focus:border-purple-500"
                                        placeholder="Enter stock quantity">
                                    <p class="text-xs text-red-500" x-text="errors.stock" x-show="errors.stock"></p>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea
                                    name="description"
                                    rows="4"
                                    class="mt-1 w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-purple-500 focus:border-purple-500"
                                    placeholder="Enter product description"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Product Images Section -->
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product Images</label>
                        <div class="flex space-x-4">
                            <!-- Image 1 -->
                            <div class="w-32 h-32 relative">
                                <input
                                    type="file"
                                    name="image1"
                                    accept="image/jpeg,image/png,image/gif"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                    @change="handleImageUpload($event, 1)">
                                <div class="w-full h-full rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-gray-400 transition-colors flex items-center justify-center" id="image1Placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <img x-show="image1Preview" :src="image1Preview" class="absolute inset-0 w-full h-full object-cover rounded-xl">
                            </div>

                            <!-- Image 2 -->
                            <div class="w-32 h-32 relative">
                                <input
                                    type="file"
                                    name="image2"
                                    accept="image/jpeg,image/png,image/gif"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                    @change="handleImageUpload($event, 2)">
                                <div class="w-full h-full rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-gray-400 transition-colors flex items-center justify-center" id="image2Placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <img x-show="image2Preview" :src="image2Preview" class="absolute inset-0 w-full h-full object-cover rounded-xl">
                            </div>

                            <!-- Image 3 -->
                            <div class="w-32 h-32 relative">
                                <input
                                    type="file"
                                    name="image3"
                                    accept="image/jpeg,image/png,image/gif"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                    @change="handleImageUpload($event, 3)">
                                <div class="w-full h-full rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-gray-400 transition-colors flex items-center justify-center" id="image3Placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <img x-show="image3Preview" :src="image3Preview" class="absolute inset-0 w-full h-full object-cover rounded-xl">
                            </div>
                        </div>
                        <p class="text-xs text-red-500" x-text="errors.image1" x-show="errors.image1"></p>
                        <p class="text-xs text-red-500" x-text="errors.image2" x-show="errors.image2"></p>
                        <p class="text-xs text-red-500" x-text="errors.image3" x-show="errors.image3"></p>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4 mt-6">
                        <button
                            type="button"
                            @click="$store.productForm.toggleForm(); isEditing = false"
                            class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-500 hover:from-purple-700 hover:to-blue-600 text-white rounded-lg transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
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
                                            @if($product->image1)
                                            <img src="{{ Storage::url($product->image1) }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover">
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
                                    <span class="text-gray-900 dark:text-white font-medium">JD {{ number_format($product->original_price, 3) }}</span>
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
                                <td class="px-6 py-4">
                                    <div class="flex justify-end space-x-3">
                                        <!-- Edit Button -->
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 text-green-600 bg-green-100 hover:bg-green-200 rounded-full transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                            </svg>
                                            Edit
                                        </a>

                                        <!-- Delete Button -->
                                        <form
                                            action="{{ route('products.destroy', $product) }}"
                                            method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 text-red-600 bg-red-100 hover:bg-red-200 rounded-full transition-colors">
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

            <!-- Pagination -->
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- Alpine.js Store -->
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

    <!-- Custom Styles -->
    <style>
        /* Fade In Animation */
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

        /* Custom Scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Dark mode scrollbar */
        .dark .overflow-x-auto::-webkit-scrollbar-track {
            background: #2d3748;
        }

        .dark .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #4a5568;
        }

        .dark .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #718096;
        }
    </style>
</x-admin-app-layout>
