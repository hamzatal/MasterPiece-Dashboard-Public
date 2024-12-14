<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-blue-900 dark:to-indigo-900 p-4 rounded-lg shadow-lg">
            <div class="flex items-center space-x-4">
                <div class="bg-white/20 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white">{{ __('Dashboard') }}</h2>
            </div>
            <div class="flex items-center space-x-4">
                <div class="bg-white/10 rounded-full p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <div class="bg-white/10 rounded-full p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    </svg>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Modern Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                @php
                $summaryCards = [
                [
                'title' => 'Total Customers',
                'value' => $totalCustomers,
                'icon' => '
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-6 8a6 6 0 0112 0H6z" />
                ',
                'color' => 'bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300'
                ],
                [
                'title' => 'Total Products',
                'value' => $totalProducts,
                'icon' => '
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />',
                'color' => 'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-300'
                ],
                [
                'title' => 'Total Orders',
                'value' => $totalOrders,
                'icon' => '
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />',
                'color' => 'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-300'
                ],
                [
                'title' => 'Total Revenue',
                'value' => "$" . number_format($totalRevenue),
                'icon' => '
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
                'color' => 'bg-indigo-100 text-indigo-600 dark:bg-indigo-900 dark:text-indigo-300'
                ]
                ];
                @endphp

                @foreach($summaryCards as $card)
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <div class="p-6 flex items-center justify-between">
                        <div class="space-y-2">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $card['title'] }}</h3>
                            <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $card['value'] }}</p>
                        </div>
                        <div class="{{ $card['color'] }} p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                {!! $card['icon'] !!}
                            </svg>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Recent Activities -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg mt-8">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Recent Activities</h3>
                    @foreach($recentActivities as $activity)
                    <div class="border-b border-gray-200 dark:border-gray-700 py-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $activity->description }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                    @endforeach

                    <!-- Pagination Links -->
                    <div class="mt-4">
                        {{ $recentActivities->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
            <!-- Advanced Tables Section -->
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Recent Orders with Enhanced Design -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 p-6 flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-500 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Recent Orders
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-gray-500 dark:text-gray-400 border-b dark:border-gray-700">
                                        <th class="pb-3 text-left">Order ID</th>
                                        <th class="pb-3 text-left">User</th>
                                        <th class="pb-3 text-left">Total</th>
                                        <th class="pb-3 text-left">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                    <tr class="border-b last:border-b-0 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <td class="py-4 text-gray-800 dark:text-gray-200">{{ $order->id }}</td>
                                        <td class="py-4 text-gray-800 dark:text-gray-200">{{ $order->user->name }}</td>
                                        <td class="py-4 text-gray-800 dark:text-gray-200">${{ number_format($order->total_price, 2) }}</td>
                                        <td class="py-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-medium
                @if($order->status == 'Completed') bg-green-100 text-green-800 dark:bg-green-600 dark:text-white
                @elseif($order->status == 'Pending') bg-yellow-200 text-yellow-800 dark:bg-yellow-500 dark:text-white
                @else bg-red-200 text-red-800 dark:bg-red-600 dark:text-white
                @endif">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Side Content -->
                <div class="space-y-8">
                    <!-- Top Products -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gray-100 dark:bg-gray-700 p-6 flex items-center justify-between">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-green-500 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                Top Products
                            </h3>
                        </div>
                        <div class="p-6">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-gray-500 dark:text-gray-400 border-b dark:border-gray-700">
                                        <th class="pb-3 text-left">Product</th>
                                        <th class="pb-3 text-left">Units Sold</th>
                                        <th class="pb-3 text-left">Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topSellingProducts as $product)
                                    <tr class="border-b last:border-b-0 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <td class="py-4 text-gray-800 dark:text-gray-200">{{ $product->product->name }}</td>
                                        <td class="py-4 text-gray-800 dark:text-gray-200">{{ $product->total_sold }}</td>
                                        <td class="py-4 text-gray-800 dark:text-gray-200">${{ number_format($product->total_revenue, 0) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Low Stock Products -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-red-50 dark:bg-red-900 p-6 flex items-center justify-between">
                            <h3 class="text-xl font-bold text-red-800 dark:text-red-300 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-red-500 dark:text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Low Stock Products
                            </h3>
                        </div>
                        <div class="p-6">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-gray-500 dark:text-gray-400 border-b dark:border-gray-700">
                                        <th class="pb-3 text-left">Product</th>
                                        <th class="pb-3 text-left">Current Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lowStockProducts as $product)
                                    <tr class="border-b last:border-b-0 hover:bg-red-50 dark:hover:bg-red-800 transition-colors">
                                        <td class="py-4 text-red-800 dark:text-red-300">{{ $product->name }}</td>
                                        <td class="py-4 font-bold text-red-600 dark:text-red-400">{{ $product->stock_quantity }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Sections -->
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Active Coupons -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-green-50 dark:bg-green-900 p-6 flex items-center justify-between">
                        <h3 class="text-xl font-bold text-green-800 dark:text-green-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-green-500 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            Active Coupons
                        </h3>
                    </div>
                    <div class="p-6">
                        <table class="w-full">
                            <thead>
                                <tr class="text-gray-500 dark:text-gray-400 border-b dark:border-gray-700">
                                    <th class="pb-3 text-left">Coupon Code</th>
                                    <th class="pb-3 text-left">Discount</th>
                                    <th class="pb-3 text-left">Valid Until</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeCoupons as $coupon)
                                <tr class="border-b last:border-b-0 hover:bg-green-50 dark:hover:bg-green-800 transition-colors">
                                    <td class="py-4 text-gray-800 dark:text-gray-200">{{ $coupon->code }}</td>
                                    <td class="py-4 text-gray-800 dark:text-gray-200">{{ $coupon->discount_percentage }}%</td>
                                    <td class="py-4 text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($coupon->valid_until)->format('Y-m-d') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Review Statistics -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-yellow-50 dark:bg-yellow-900 p-6 flex items-center justify-between">
                        <h3 class="text-xl font-bold text-yellow-800 dark:text-yellow-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-yellow-500 dark:text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            Review Statistics
                        </h3>
                    </div>

                    <div class="p-6 grid grid-cols-2 gap-4">

                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Average Rating</p>
                            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-300">{{ number_format($averageRating, 2) }} / 5</p>
                        </div>

                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Reviews</p>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-300">{{ $totalReviews }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
