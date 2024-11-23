<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Discounts') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">Discount List</h3>
                <a href="{{ route('discounts.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Add New Discount</a>
            </div>

            <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">Code</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">Discount Type</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">Discount Value</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">Min Order Value</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">Expiry Date</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-white">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($discounts as $discount)
                        <tr class="border-t border-gray-300 dark:border-gray-700">
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $discount->code }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ ucfirst($discount->discount_type) }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $discount->discount_value }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $discount->min_order_value ?? 'N/A' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $discount->expiry_date ? \Carbon\Carbon::parse($discount->expiry_date)->format('d M Y') : 'No Expiry' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">
                                <a href="{{ route('discounts.edit', $discount->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                <form action="{{ route('discounts.destroy', $discount->id) }}" method="POST" class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($discounts->isEmpty())
                <div class="mt-4 text-center text-gray-500 dark:text-gray-400">No discounts available.</div>
            @endif
        </div>
    </div>

</x-app-layout>
