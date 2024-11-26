<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create Discount') }}
            </h2>
            <nav class="flex space-x-4 text-sm">
                <a href="{{ route('discounts.index') }}" class="text-gray-400 dark:text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400">Discounts</a>
                <span class="text-gray-400 dark:text-gray-500">/</span>
                <span class="text-indigo-600 dark:text-indigo-400">Create</span>
            </nav>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
            <!-- Form Header -->
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-indigo-50 dark:bg-indigo-900/50 rounded-lg">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New Discount</h3>
                </div>
            </div>

            <!-- Form Content -->
            <form action="{{ route('discounts.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Discount Code -->
                <div class="space-y-1">
                    <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Discount Code</label>
                    <input type="text"
                           id="code"
                           name="code"
                           value="{{ old('code') }}"
                           class="mt-1 block w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors duration-200"
                           placeholder="Enter discount code"
                           required>
                    @error('code')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Two Columns Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Discount Type -->
                    <div class="space-y-1">
                        <label for="discount_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Discount Type</label>
                        <select id="discount_type"
                                name="discount_type"
                                class="mt-1 block w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors duration-200">
                            <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage Off</option>
                            <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                        </select>
                        @error('discount_type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Discount Value -->
                    <div class="space-y-1">
                        <label for="discount_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Discount Value</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500" id="value-symbol">%</span>
                            </div>
                            <input type="number"
                                   id="discount_value"
                                   name="discount_value"
                                   value="{{ old('discount_value') }}"
                                   class="mt-1 block w-full pl-8 pr-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors duration-200"
                                   placeholder="Enter value"
                                   step="0.01"
                                   required>
                        </div>
                        @error('discount_value')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Minimum Order Value -->
                    <div class="space-y-1">
                        <label for="min_order_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Minimum Order Value</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">$</span>
                            </div>
                            <input type="number"
                                   id="min_order_value"
                                   name="min_order_value"
                                   value="{{ old('min_order_value') }}"
                                   class="mt-1 block w-full pl-8 pr-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors duration-200"
                                   placeholder="Optional"
                                   step="0.01">
                        </div>
                        @error('min_order_value')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Expiry Date -->
                    <div class="space-y-1">
                        <label for="expiry_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Expiry Date</label>
                        <input type="date"
                               id="expiry_date"
                               name="expiry_date"
                               value="{{ old('expiry_date') }}"
                               class="mt-1 block w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors duration-200"
                               min="{{ date('Y-m-d') }}">
                        @error('expiry_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-3 pt-6">
                    <a href="{{ route('discounts.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-colors duration-300">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-colors duration-300">
                        Create Discount
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for dynamic value symbol -->
    <script>
        const discountType = document.getElementById('discount_type');
        const valueSymbol = document.getElementById('value-symbol');

        discountType.addEventListener('change', function() {
            valueSymbol.textContent = this.value === 'percentage' ? '%' : '$';
        });
    </script>
</x-app-layout>
