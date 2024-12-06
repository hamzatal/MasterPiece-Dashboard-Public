<x-app-layout>
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

                @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

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
                            class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-300" />
                    </div>

                    {{-- Category Dropdown --}}
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Category
                        </label>
                        <select
                            name="category_id"
                            id="category_id"
                            class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-300"
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
                        class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-300"
                        placeholder="Enter product description"
                        required>{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Price Input --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Price
                        </label>
                        <input
                            type="number"
                            name="price"
                            id="price"
                            value="{{ old('price', $product->price) }}"
                            step="0.01"
                            placeholder="Enter price"
                            required
                            class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-300" />
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
                            class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-300" />
                    </div>
                </div>

                {{-- Image Upload --}}
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Current Image
                    </label>
                    <div class="flex items-center space-x-6">
                        @if($product->image)
                        <img
                            src="{{ Storage::url($product->image) }}"
                            alt="{{ $product->name }}"
                            class="w-64 h-64 object-cover rounded-2xl shadow-lg" />
                        @else
                        <div class="w-64 h-64 bg-gray-200 dark:bg-gray-700 rounded-2xl flex items-center justify-center">
                            <span class="text-gray-500 dark:text-gray-300">No Image</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Update Image
                    </label>
                    <input
                        type="file"
                        name="image"
                        id="image"
                        accept="image/*"
                        class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100
                            dark:file:bg-indigo-900 dark:file:text-indigo-200" />
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
</x-app-layout>