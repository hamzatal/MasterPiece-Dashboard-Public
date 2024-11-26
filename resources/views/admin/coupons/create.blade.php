<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-800 dark:text-gray-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.91 8.84 8.56 21.16a4.25 4.25 0 0 1-6-6L14.89 2.84a2.13 2.13 0 0 1 3 3L5.64 18.08a1.07 1.07 0 0 1-1.5-1.5L15.49 5.23"></path>
            </svg>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Add New Coupon') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl p-8">
            <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
                <div class="flex items-center space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-indigo-600 dark:text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                        <path d="M12 12h.01"></path>
                        <path d="M17 12h.01"></path>
                        <path d="M7 12h.01"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Coupon Information</h3>
                </div>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Create a new discount coupon for your customers.</p>
            </div>

            <form action="{{ route('coupons.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-6">
                        <div>
                            <label for="code" class="flex items-center space-x-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.91 8.84 8.56 21.16a4.25 4.25 0 0 1-6-6L14.89 2.84a2.13 2.13 0 0 1 3 3L5.64 18.08a1.07 1.07 0 0 1-1.5-1.5L15.49 5.23"></path>
                                </svg>
                                <span>Coupon Code</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="code" id="code"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white dark:border-gray-600 transition-colors"
                                    value="{{ old('code') }}" required>
                                <button type="button" onclick="generateCouponCode()"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="17 8 12 3 7 8"></polyline>
                                        <line x1="12" y1="3" x2="12" y2="15"></line>
                                    </svg>
                                </button>
                            </div>
                            @error('code')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="discount_type" class="flex items-center space-x-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="16"></line>
                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                </svg>
                                <span>Discount Type</span>
                            </label>
                            <select name="discount_type" id="discount_type"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white dark:border-gray-600 transition-colors"
                                required>
                                <option value="">Select Type</option>
                                <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                            </select>
                            @error('discount_type')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label for="discount_value" class="flex items-center space-x-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                                <span>Discount Value</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="discount_value" id="discount_value"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white dark:border-gray-600 transition-colors"
                                    value="{{ old('discount_value') }}" required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-500 dark:text-gray-400" id="discount-symbol">
                                    %
                                </div>
                            </div>
                            @error('discount_value')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="min_order_value" class="flex items-center space-x-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span>Minimum Order Value</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-500 dark:text-gray-400">
                                    $
                                </span>
                                <input type="number" name="min_order_value" id="min_order_value"
                                    class="w-full pl-8 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white dark:border-gray-600 transition-colors"
                                    value="{{ old('min_order_value') }}">
                            </div>
                            @error('min_order_value')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="expiry_date" class="flex items-center space-x-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>Expiry Date</span>
                    </label>
                    <input type="date" name="expiry_date" id="expiry_date"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white dark:border-gray-600 transition-colors"
                        value="{{ old('expiry_date') }}">
                    @error('expiry_date')
                        <div class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex justify-end mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" class="flex items-center space-x-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        <span>Create Coupon</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Update discount symbol based on type selection
        document.getElementById('discount_type').addEventListener('change', function() {
            const symbol = document.getElementById('discount-symbol');
            symbol.textContent = this.value === 'percentage' ? '%' : '$';
        });

        // Generate random coupon code
        function generateCouponCode() {
            const charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let code = '';
            for (let i = 0; i < 8; i++) {
                code += charset.charAt(Math.floor(Math.random() * charset.length));
            }
            document.getElementById('code').value = code;
        }
    </script>
</x-app-layout>
