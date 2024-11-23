{{-- resources/views/orders/partials/table-rows.blade.php --}}
@foreach($orders as $order)
<tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
        #{{ $order->id }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center">
            <div class="flex-shrink-0 h-10 w-10">
                <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                    <span class="text-gray-600 dark:text-gray-300 text-sm font-medium">
                        {{ strtoupper(substr($order->user->name ?? 'NA', 0, 2)) }}
                    </span>
                </div>
            </div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-900 dark:text-gray-200">
                    {{ $order->customer ? $order->customer->name : 'No customer name available' }}
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $order->customer->email ?? 'No email available' }}
                </div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-900 dark:text-gray-200">${{ number_format($order->total, 2) }}</div>
        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $order->orderItems->count() ?? 0 }} items</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-900 dark:text-gray-200">
            {{ $order->created_at->format('M d, Y') }}
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400">
            {{ $order->created_at->format('h:i A') }}
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
            @if($order->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
            @elseif($order->status == 'processing') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
            @elseif($order->status == 'shipped') bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200
            @elseif($order->status == 'delivered') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
            @elseif($order->status == 'cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
            @endif">
            {{ ucfirst($order->status) }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <div class="flex justify-end space-x-2">
            <a href="{{ route('orders.view', $order) }}"
                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-600 p-2 hover:bg-blue-50 dark:hover:bg-blue-900/50 rounded-full transition-colors"
                title="View Order">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <a href="{{ route('orders.edit', $order) }}"
                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600 p-2 hover:bg-indigo-50 dark:hover:bg-indigo-900/50 rounded-full transition-colors"
                title="Edit Order">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
            </a>
        </div>
    </td>
</tr>
@endforeach
