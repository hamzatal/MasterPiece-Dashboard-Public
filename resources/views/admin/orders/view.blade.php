<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    Order #{{ $order->id }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Created on {{ $order->created_at->format('M d, Y h:i A') }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition duration-150 ease-in-out shadow-sm hover:shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Orders
                </a>
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition duration-150 ease-in-out shadow-sm hover:shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Order
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Order Summary Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-6">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <span class="px-4 py-2 rounded-full text-sm font-semibold
                                @if($order->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @elseif($order->status == 'processing') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                @elseif($order->status == 'shipped') bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200
                                @elseif($order->status == 'delivered') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($order->status == 'cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Updated {{ $order->updated_at->diffForHumans() }}
                            </div>
                        </div>
                        @if($order->payment_status)
                        <div class="flex items-center">
                            <span class="px-4 py-2 rounded-full text-sm font-semibold
                                @if($order->payment_status == 'paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($order->payment_status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @endif">
                                Payment: {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Order Items -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Items Table -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Order Items</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @forelse($order->items ?? [] as $item)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 ease-in-out">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="h-12 w-12 flex-shrink-0">
                                                        <img class="h-12 w-12 rounded-lg object-cover shadow-sm" src="{{ $item->product->image_url ?? 'default-image-url' }}" alt="{{ $item->product->name ?? 'Product Image' }}">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $item->product->name ?? 'Product Name Unavailable' }}</div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">SKU: {{ $item->product->sku ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                                {{ $item->quantity ?? 0 }}
                                            </td>
                                            <td class="px-6 py-4 text-right text-sm text-gray-500 dark:text-gray-400">
                                                ${{ number_format($item->unit_price ?? 0, 2) }}
                                            </td>
                                            <td class="px-6 py-4 text-right text-sm font-medium text-gray-900 dark:text-gray-100">
                                                ${{ number_format($item->total ?? 0, 2) }}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                                No items found in this order.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="px-6 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-300">Subtotal</td>
                                            <td class="px-6 py-3 text-right text-sm font-medium text-gray-900 dark:text-gray-100">${{ number_format($order->subtotal ?? 0, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="px-6 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-300">Tax</td>
                                            <td class="px-6 py-3 text-right text-sm font-medium text-gray-900 dark:text-gray-100">${{ number_format($order->tax ?? 0, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="px-6 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-300">Total</td>
                                            <td class="px-6 py-3 text-right text-lg font-bold text-gray-900 dark:text-gray-100">${{ number_format($order->total ?? 0, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Payment Information</h3>
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $order->payment_method }}</p>
                                        @if($order->card_last_four)
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Card ending in {{ $order->card_last_four }}</p>
                                        @endif
                                    </div>
                                </div>

                                @if($order->payment_id)
                                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <div class="text-sm">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-gray-500 dark:text-gray-400">Transaction ID</span>
                                            <span class="font-mono text-gray-900 dark:text-gray-100">{{ $order->payment_id }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Customer & Shipping Info -->
                <div class="space-y-6">
                    <!-- Customer Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Customer Information</h3>
                            @if($order->Customer)
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                        <span class="text-white text-lg font-medium">
                                            {{ strtoupper(substr($order->Customer->name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $order->Customer->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $order->Customer->email }}</div>
                                    </div>
                                </div>
                                @if($order->Customer->phone)
                                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <div class="
<div class=" flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span>{{ $order->Customer->phone }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @else
                            <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center justify-center p-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                No customer information available
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Shipping Details</h3>
                            @if($order->shipping_address)
                            <div class="space-y-4">
                                <!-- Shipping Address -->
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                    <div class="flex items-start space-x-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <div class="text-sm text-gray-600 dark:text-gray-300 flex-1">
                                            <p class="font-medium">{{ $order->shipping_address->name }}</p>
                                            <p class="mt-1">{{ $order->shipping_address->street }}</p>
                                            <p>{{ $order->shipping_address->city }}, {{ $order->shipping_address->state }} {{ $order->shipping_address->zip }}</p>
                                            <p>{{ $order->shipping_address->country }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Shipping Method -->
                                @if($order->shipping_method)
                                <div class="flex items-center space-x-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Shipping Method</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $order->shipping_method }}</p>
                                    </div>
                                </div>
                                @endif

                                <!-- Tracking Information -->
                                @if($order->tracking_number)
                                <div class="flex items-center space-x-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Tracking Number</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 font-mono">{{ $order->tracking_number }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @else
                            <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center justify-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                No shipping information available
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Timeline -->
                    @if($order->status != 'cancelled')
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Order Timeline</h3>
                            <div class="relative">
                                <div class="absolute h-full w-0.5 bg-gray-200 dark:bg-gray-700 left-4"></div>
                                <div class="space-y-6 relative">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-9 h-9 rounded-full bg-blue-500 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Order Placed</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                        </div>
                                    </div>

                                    @if($order->status == 'processing' || $order->status == 'shipped' || $order->status == 'delivered')
                                    <div class="flex items-center space-x-4">
                                        <div class="w-9 h-9 rounded-full bg-blue-500 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Processing</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Order is being prepared</p>
                                        </div>
                                    </div>
                                    @endif

                                    @if($order->status == 'shipped' || $order->status == 'delivered')
                                    <div class="flex items-center space-x-4">
                                        <div class="w-9 h-9 rounded-full bg-blue-500 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Shipped</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Order has been shipped</p>
                                        </div>
                                    </div>
                                    @endif

                                    @if($order->status == 'delivered')
                                    <div class="flex items-center space-x-4">
                                        <div class="w-9 h-9 rounded-full bg-green-500 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Delivered</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Order has been delivered</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
