@foreach($orders as $order)
<tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
        #{{ $order->id }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-900 dark:text-gray-200">
            {{ $order->customer->name }}
        </div>
        <div class="text-sm text-gray-500 dark:text-gray-400">
            {{ $order->customer->email }}
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
        ${{ number_format($order->total, 2) }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
            @if($order->status == 'pending') bg-yellow-100 text-yellow-800
            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
            @elseif($order->status == 'shipped') bg-green-100 text-green-800
            @elseif($order->status == 'delivered') bg-green-200 text-green-900
            @elseif($order->status == 'cancelled') bg-red-100 text-red-800
            @endif">
            {{ ucfirst($order->status) }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <div class="flex justify-end space-x-2">
            <a href="{{ route('orders.view', $order) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <button onclick="updateOrderStatus('{{ $order->id }}')" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </td>
</tr>
@endforeach
