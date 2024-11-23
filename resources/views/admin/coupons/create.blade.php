<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Coupon') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6">
        <form action="{{ route('coupons.store') }}" method="POST">
            @csrf

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Coupon Code</label>
                    <input type="text" name="code" id="code" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600" value="{{ old('code') }}" required>
                    @error('code') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="discount_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Discount Type</label>
                    <input type="text" name="discount_type" id="discount_type" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600" value="{{ old('discount_type') }}" required>
                    @error('discount_type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="discount_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Discount Value</label>
                    <input type="number" name="discount_value" id="discount_value" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600" value="{{ old('discount_value') }}" required>
                    @error('discount_value') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="min_order_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Minimum Order Value</label>
                    <input type="number" name="min_order_value" id="min_order_value" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600" value="{{ old('min_order_value') }}">
                    @error('min_order_value') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="expiry_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Expiry Date</label>
                    <input type="date" name="expiry_date" id="expiry_date" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600" value="{{ old('expiry_date') }}">
                    @error('expiry_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-200 ease-in-out">Add Coupon</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
