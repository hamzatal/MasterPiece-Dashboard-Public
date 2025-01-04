<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">
                Edit Product
            </h2>
            <div class="text-sm text-gray-500 dark:text-gray-300">
                Last modified: {{ $product->updated_at->diffForHumans() }}
            </div>
        </div>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow-2xl rounded-2xl overflow-hidden">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                {{-- Error Messages --}}
                @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Name and Category --}}
                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Name Input --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Product Name
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', $product->name) }}"
                            placeholder="Enter product name"
                            required
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-300" />
                    </div>

                    {{-- Category Dropdown --}}
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Category
                        </label>
                        <select
                            name="category_id"
                            id="category_id"
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-300"
                            required>
                            @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        rows="4"
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-300"
                        placeholder="Enter product description"
                        required>{{ old('description', $product->description) }}</textarea>
                </div>

                {{-- Price and Stock --}}
                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Price Input --}}
                    <div>
                        <label for="original_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Price
                        </label>
                        <input
                            type="number"
                            name="original_price"
                            id="original_price"
                            value="{{ old('original_price', $product->original_price) }}"
                            step="0.01"
                            placeholder="Enter price"
                            required
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-300" />
                    </div>

                    {{-- Stock Input --}}
                    <div>
                        <label for="stock_quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Stock Quantity
                        </label>
                        <input
                            type="number"
                            name="stock_quantity"
                            id="stock_quantity"
                            value="{{ old('stock_quantity', $product->stock_quantity) }}"
                            placeholder="Enter stock quantity"
                            required
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-300" />
                    </div>
                </div>

                {{-- Size and Color --}}
                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Size Dropdown with Custom Option --}}
                    <div>
                        <label for="size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Size
                        </label>
                        <select
                            name="size"
                            id="size"
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-300"
                            onchange="toggleCustomInput('size', 'customSizeInput')">
                            <option value="">Select Size</option>
                            <option value="S" {{ old('size', $product->size) == 'S' ? 'selected' : '' }}>Small (S)</option>
                            <option value="M" {{ old('size', $product->size) == 'M' ? 'selected' : '' }}>Medium (M)</option>
                            <option value="L" {{ old('size', $product->size) == 'L' ? 'selected' : '' }}>Large (L)</option>
                            <option value="XL" {{ old('size', $product->size) == 'XL' ? 'selected' : '' }}>Extra Large (XL)</option>
                            <option value="40" {{ old('size', $product->size) == '40' ? 'selected' : '' }}>40</option>
                            <option value="41" {{ old('size', $product->size) == '41' ? 'selected' : '' }}>41</option>
                            <option value="42" {{ old('size', $product->size) == '42' ? 'selected' : '' }}>42</option>
                            <option value="43" {{ old('size', $product->size) == '43' ? 'selected' : '' }}>43</option>
                            <option value="44" {{ old('size', $product->size) == '44' ? 'selected' : '' }}>44</option>
                            <option value="45" {{ old('size', $product->size) == '45' ? 'selected' : '' }}>45</option>
                            <option value="custom">Custom Size</option>
                        </select>
                        {{-- Custom Size Input (Shows when "Custom" is selected) --}}
                        <input
                            x-show="showCustomSizeInput"
                            type="text"
                            name="custom_size"
                            id="customSizeInput"
                            placeholder="Enter custom size"
                            class="mt-2 w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-300"
                            style="display: none;" />
                    </div>

                    {{-- Color Dropdown with Custom Option --}}
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Color
                        </label>
                        <select
                            name="color"
                            id="color"
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-300"
                            onchange="toggleCustomInput('color', 'customColorInput')">
                            <option value="">Select Color</option>
                            <option value="Black" {{ old('color', $product->color) == 'Black' ? 'selected' : '' }}>Black</option>
                            <option value="White" {{ old('color', $product->color) == 'White' ? 'selected' : '' }}>White</option>
                            <option value="Red" {{ old('color', $product->color) == 'Red' ? 'selected' : '' }}>Red</option>
                            <option value="Blue" {{ old('color', $product->color) == 'Blue' ? 'selected' : '' }}>Blue</option>
                            <option value="Green" {{ old('color', $product->color) == 'Green' ? 'selected' : '' }}>Green</option>
                            <option value="Yellow" {{ old('color', $product->color) == 'Yellow' ? 'selected' : '' }}>Yellow</option>
                            <option value="Gray" {{ old('color', $product->color) == 'Gray' ? 'selected' : '' }}>Gray</option>
                            <option value="custom">Custom Color</option>
                        </select>
                        {{-- Custom Color Input (Shows when "Custom" is selected) --}}
                        <input
                            x-show="showCustomColorInput"
                            type="text"
                            name="custom_color"
                            id="customColorInput"
                            placeholder="Enter custom color"
                            class="mt-2 w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-300"
                            style="display: none;" />
                    </div>
                </div>

                {{-- Image Upload Section --}}
                <div class="space-y-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Product Images
                    </label>

                    <div class="flex space-x-4">
                        {{-- Image 1 --}}
                        <div class="w-32 h-32 relative">
                            <input
                                type="file"
                                name="image1"
                                id="image1"
                                accept="image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                onchange="previewImage(event, 'image1Preview')" />
                            <div class="w-full h-full rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-gray-400 transition-colors flex items-center justify-center" id="image1Placeholder">
                                @if($product->image1)
                                <img id="image1Preview" src="{{ Storage::url($product->image1) }}" class="w-full h-full object-cover rounded-xl" />
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                @endif
                            </div>
                        </div>

                        {{-- Image 2 --}}
                        <div class="w-32 h-32 relative">
                            <input
                                type="file"
                                name="image2"
                                id="image2"
                                accept="image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                onchange="previewImage(event, 'image2Preview')" />
                            <div class="w-full h-full rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-gray-400 transition-colors flex items-center justify-center" id="image2Placeholder">
                                @if($product->image2)
                                <img id="image2Preview" src="{{ Storage::url($product->image2) }}" class="w-full h-full object-cover rounded-xl" />
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                @endif
                            </div>
                        </div>

                        {{-- Image 3 --}}
                        <div class="w-32 h-32 relative">
                            <input
                                type="file"
                                name="image3"
                                id="image3"
                                accept="image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                onchange="previewImage(event, 'image3Preview')" />
                            <div class="w-full h-full rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-gray-400 transition-colors flex items-center justify-center" id="image3Placeholder">
                                @if($product->image3)
                                <img id="image3Preview" src="{{ Storage::url($product->image3) }}" class="w-full h-full object-cover rounded-xl" />
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end space-x-4 pt-6">
                    <a
                        href="{{ route('products.index') }}"
                        class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300 rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-300">
                        Cancel
                    </a>
                    <button
                        type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400 transition duration-300">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event, previewId) {
            const input = event.target;
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(input.id + 'Placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('w-full', 'h-full', 'object-cover', 'rounded-xl');
                    placeholder.innerHTML = '';
                    placeholder.appendChild(img);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                placeholder.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                `;
            }
        }

        function toggleCustomInput(selectId, customInputId) {
            const select = document.getElementById(selectId);
            const customInput = document.getElementById(customInputId);

            if (select.value === 'custom') {
                customInput.style.display = 'block';
            } else {
                customInput.style.display = 'none';
            }

        }
    </script>
</x-admin-app-layout>