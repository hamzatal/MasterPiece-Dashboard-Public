```blade
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Discount') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 px-4">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-2xl">
            <div class="p-8">
                <div class="flex items-center mb-6 space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z" clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Discount</h3>
                </div>

                <form action="{{ route('discounts.update', $discount->id) }}" method="POST" x-data="discountForm()">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="code" class="flex items-center space-x-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 001-1v-1a1 1 0 00-1 1v1zm7-1a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                                <span>Discount Code</span>
                            </label>
                            <input type="text" id="code" name="code" value="{{ old('code', $discount->code) }}"
                                class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 dark:bg-gray-700 dark:text-white"
                                required>
                            @error('code')
                                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="discount_type" class="flex items-center space-x-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                </svg>
                                <span>Discount Type</span>
                            </label>
                            <select id="discount_type" name="discount_type"
                                class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 dark:bg-gray-700 dark:text-white"
                                required>
                                <option value="percentage" {{ $discount->discount_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                <option value="fixed" {{ $discount->discount_type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                            </select>
                            @error('discount_type')
                                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="discount_value" class="flex items-center space-x-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8.433 7.418c.155-.9.52-1.52 1.242-1.52.721 0 1.086.62 1.24 1.52.156.9 0 1.58-.238 1.58-.238 0-.602 0-1.002-.58a.572.572 0 00-.602-.38c-.32 0-.617.2-.617.38 0 .18.298.38.617.38.32 0 .602-.2.602-.38 0-.18-.238-.38-.238-.58 0-.4.68-.58 1.24-1.52.56-.94 0-1.58-1.24-1.58-1.24 0-1.8.64-1.24 1.58.56.94 1.24 1.12 1.24 1.52 0 .4-.68.58-1.24 1.52-.56.94 0 1.58 1.24 1.58 1.24 0 1.8-.64 1.24-1.58-.56-.94-1.24-1.12-1.24-1.52z" />
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm3 6a1 1 0 011-1h4a1 1 0 010 2H8a1 1 0 01-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>Discount Value</span>
                            </label>
                            <input type="number" id="discount_value" name="discount_value"
                                value="{{ old('discount_value', $discount->discount_value) }}"
                                class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 dark:bg-gray-700 dark:text-white"
                                required>
                            @error('discount_value')
                                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="min_order_value" class="flex items-center space-x-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 005 18h10a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                                </svg>
                                <span>Minimum Order Value</span>
                            </label>
                            <input type="number" id="min_order_value" name="min_order_value"
                                value="{{ old('min_order_value', $discount->min_order_value) }}"
                                class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 dark:bg-gray-700 dark:text-white">
                            @error('min_order_value')
                                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="expiry_date" class="flex items-center space-x-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                <span>Expiry Date</span>
                            </label>
                            <input type="date" id="expiry_date" name="expiry_date"
                                value="{{ old('expiry_date', $discount->expiry_date) }}"
                                class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 dark:bg-gray-700 dark:text-white">
                            @error('expiry_date')
                                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                            class="flex items-center space-x-2 bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 transition duration-300 shadow-md hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z" />
                            </svg>
                            <span>Update Discount</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function discountForm() {
            return {
                // Optional Alpine.js interactions can be added here
            }
        }
    </script>
    @endpush
</x-app-layout>
```
