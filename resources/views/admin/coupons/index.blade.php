<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Coupons Management') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Coupons</h1>
            <a href="{{ route('coupons.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 ease-in-out">
                + Add Coupon
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-300">Code</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-300">Type</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-300">Value</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-300">Min Order</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-300">Expiry Date</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-gray-900 dark:text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @forelse ($coupons as $coupon)
                    <tr>
                        <td class="px-4 py-2">{{ $coupon->code }}</td>
                        <td class="px-4 py-2 capitalize">{{ $coupon->discount_type }}</td>
                        <td class="px-4 py-2">{{ $coupon->discount_value }}</td>
                        <td class="px-4 py-2">{{ $coupon->min_order_value ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $coupon->expiry_date ?? 'No Expiry' }}</td>
                        <td class="px-4 py-2 text-right">
                            <a href="{{ route('coupons.edit', $coupon->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                Edit
                            </a>
                            <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 ml-4">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-2 text-center text-gray-500 dark:text-gray-400">
                            No coupons found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $coupons->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
