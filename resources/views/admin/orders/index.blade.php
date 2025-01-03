<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Orders Management') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Manage and track all your orders in one place</p>
            </div>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl sm:px-6 lg:px-8 mr-auto">
            <!-- Order Management Buttons -->
            <div class="mb-6 flex justify-end gap-4">
                <a href="{{ route('orders.export') }}"
                    class="inline-flex items-center px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-all shadow-sm hover:shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export Orders
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                            <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Orders</h3>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-200">{{ $statistics['totalOrders'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                            <svg class="h-6 w-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Complete Orders</h3>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-200">{{ $statistics['completedOrders'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                            <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Pend-Process Orders</h3>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-200">{{ $statistics['pendingOrders'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 dark:bg-red-900 rounded-full">
                            <svg class="h-6 w-6 text-red-600 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Cancelled Orders</h3>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-200">{{ $statistics['cancelledOrders'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-full">
                            <svg class="h-6 w-6 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Quick Stats</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Filtered Orders</p>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $orders->total() ?? 0 }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Total Value</p>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">${{ number_format($orders->sum('total') ?? 0, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                <form action="{{ route('orders.index') }}" method="GET" class="space-y-6">


                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search Bar -->
                        <div class="md:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                <svg class="inline-block w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Search Orders
                            </label>
                            <div class="relative">
                                <input
                                    type="text"
                                    id="search"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Search by order ID, customer name, or product..."
                                    class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 ease-in-out">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Filters Container -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Status Filter -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    <svg class="inline-block w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                    Status
                                </label>
                                <select
                                    id="status"
                                    name="status"
                                    x-data="{ status: '{{ request('status') }}' }"
                                    x-model="status"
                                    @change="$el.form.submit()"
                                    class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 ease-in-out">
                                    <option value="">All Statuses</option>
                                    @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                                    <option
                                        value="{{ $status }}"
                                        @selected(request('status')==$status)>
                                        {{ ucfirst($status) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Time Filter -->
                            <div>
                                <label for="time_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    <svg class="inline-block w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Time Period
                                </label>
                                <select
                                    id="time_filter"
                                    name="time_filter"
                                    x-data="{ time_filter: '{{ request('time_filter') }}' }"
                                    x-model="time_filter"
                                    @change="$el.form.submit()"
                                    class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 ease-in-out">
                                    <option value="">All Time</option>
                                    <option value="today" @selected(request('time_filter')=='today' )>Today</option>
                                    <option value="yesterday" @selected(request('time_filter')=='yesterday' )>Yesterday</option>
                                    <option value="this_week" @selected(request('time_filter')=='this_week' )>This Week</option>
                                    <option value="last_week" @selected(request('time_filter')=='last_week' )>Last Week</option>
                                    <option value="this_month" @selected(request('time_filter')=='this_month' )>This Month</option>
                                    <option value="last_month" @selected(request('time_filter')=='last_month' )>Last Month</option>
                                    <option value="custom" @selected(request('time_filter')=='custom' )>Custom Range</option>
                                </select>
                            </div>
                        </div>
                    </div>



                    <!-- Custom Date Range -->
                    <div x-data="{ showCustomDates: '{{ request('time_filter') }}' === 'custom' }"
                        x-show="showCustomDates"
                        class="grid grid-cols-1 md:grid-cols-2 gap-4"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100">
                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                <svg class="inline-block w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                From Date
                            </label>
                            <input
                                type="date"
                                id="date_from"
                                name="date_from"
                                value="{{ request('date_from') }}"
                                class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 ease-in-out">
                        </div>
                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                <svg class="inline-block w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                To Date
                            </label>
                            <input
                                type="date"
                                id="date_to"
                                name="date_to"
                                value="{{ request('date_to') }}"
                                class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 ease-in-out">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center pt-4">
                        <!-- Apply Filters Button (visible only for custom date range) -->
                        <div x-data="{ showCustomDates: '{{ request('time_filter') }}' === 'custom' }"
                            x-show="showCustomDates"
                            x-transition>
                            <button
                                type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 ease-in-out focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Apply Date Range
                            </button>
                        </div>

                        <!-- Clear Filters Button (visible when any filter is active) -->
                        @if(request('status') || request('time_filter') || request('search'))
                        <a href="{{ route('orders.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg transition-colors duration-200 ease-in-out">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Clear All Filters
                        </a>
                        @endif
                    </div>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <svg class="inline-block w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Order ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody id="orders-table-body" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
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
                                            {{ $order->user ? $order->user->name : 'No customer name available' }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $order->user->email ?? 'No email available' }}
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
                                    <!-- <a href="{{ route('orders.edit', $order) }}"
                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600 p-2 hover:bg-indigo-50 dark:hover:bg-indigo-900/50 rounded-full transition-colors"
                                        title="Edit Order">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a> -->

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- Order Status Update Modal -->
    <div id="status-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">Update Order Status</h3>
                <div class="mt-2 px-7 py-3">
                    <select id="new-status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="update-status" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-lg w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Update Status
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('order-search');
            const statusFilter = document.getElementById('status-filter');
            const dateFilter = document.getElementById('date-filter');
            const ordersTableBody = document.getElementById('orders-table-body');
            let searchTimeout;

            // Function to perform the search and filter
            function performSearch() {
                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(() => {
                    // Show loading state
                    ordersTableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center">
                            <div class="animate-pulse flex justify-center items-center">
                                <div class="w-6 h-6 border-t-2 border-b-2 border-blue-500 rounded-full animate-spin"></div>
                                <span class="ml-2">Loading...</span>
                            </div>
                        </td>
                    </tr>
                `;

                    // Build the query string
                    const params = new URLSearchParams({
                        search: searchInput.value,
                        status: statusFilter.value,
                        date: dateFilter.value
                    });

                    // Make the AJAX request to fetch filtered orders
                    fetch(`/orders/filter?${params.toString()}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Replace the table body content with fetched orders
                            ordersTableBody.innerHTML = '';
                            if (data.orders.length > 0) {
                                data.orders.forEach(order => {
                                    const orderRow = document.createElement('tr');
                                    orderRow.innerHTML = `
                                <td>${order.id}</td>
                                <td>${order.customer_name}</td>
                                <td>${order.status}</td>
                                <td>${order.date}</td>
                            `;
                                    ordersTableBody.appendChild(orderRow);
                                });
                            } else {
                                ordersTableBody.innerHTML = `
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-red-600">No orders found</td>
                            </tr>
                        `;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            ordersTableBody.innerHTML = `
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-red-600">An error occurred while fetching the data. Please try again.</td>
                        </tr>
                    `;
                        });
                }, 300); // Debounce delay
            }

            // Event listeners for search and filters
            searchInput.addEventListener('input', performSearch);
            statusFilter.addEventListener('change', performSearch);
            dateFilter.addEventListener('change', performSearch);

            // Handle browser back/forward buttons (updates the filters based on URL)
            window.addEventListener('popstate', function() {
                const urlParams = new URLSearchParams(window.location.search);

                // Update form values based on URL parameters
                searchInput.value = urlParams.get('search') || '';
                statusFilter.value = urlParams.get('status') || '';
                dateFilter.value = urlParams.get('date') || '';

                // Perform search with new values
                performSearch();
            });

            // Initialize the search and filter state when the page loads
            performSearch();

            // Export Orders
            document.getElementById('export-orders').addEventListener('click', function() {
                const status = statusFilter.value;
                const dateRange = dateFilter.value;
                const searchTerm = searchInput.value;
                window.location.href = `{{ route('orders.export') }}?status=${status}&date=${dateRange}&search=${encodeURIComponent(searchTerm)}`;
            });

            // Open status update modal (for updating order status)
            let currentOrderId;
            const statusModal = document.getElementById('status-modal');

            function updateOrderStatus(orderId) {
                currentOrderId = orderId;
                statusModal.classList.remove('hidden');
            }

            // Close modal when clicking outside
            statusModal.addEventListener('click', function(e) {
                if (e.target === statusModal) {
                    statusModal.classList.add('hidden');
                }
            });

            // Handle status update
            document.getElementById('update-status').addEventListener('click', function() {
                const newStatus = document.getElementById('new-status').value;

                fetch(`{{ route('orders.update-status', '') }}/${currentOrderId}`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            status: newStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        statusModal.classList.add('hidden');
                        performSearch();
                        showNotification('Order status updated successfully', 'success');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Failed to update order status', 'error');
                    });
            });

            // Show notifications on order status update
            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                notification.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white transform transition-all duration-300 translate-y-0`;
                notification.textContent = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.classList.add('translate-y-full', 'opacity-0');
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            // Initialize tooltips for the page (if any)
            function initializeTooltips() {
                const tooltips = document.querySelectorAll('[title]');
                tooltips.forEach(tooltip => {
                    tooltip.addEventListener('mouseenter', e => {
                        const title = e.target.getAttribute('title');
                        if (!title) return;

                        const tooltipEl = document.createElement('div');
                        tooltipEl.className = 'absolute z-50 px-2 py-1 text-xs text-white bg-gray-900 rounded shadow-lg';
                        tooltipEl.textContent = title;
                        document.body.appendChild(tooltipEl);

                        const rect = e.target.getBoundingClientRect();
                        tooltipEl.style.top = `${rect.top - tooltipEl.offsetHeight - 5}px`;
                        tooltipEl.style.left = `${rect.left + (rect.width - tooltipEl.offsetWidth) / 2}px`;

                        e.target.addEventListener('mouseleave', () => tooltipEl.remove());
                    });
                });
            }

            // Initialize tooltips on page load
            initializeTooltips();
        });
    </script>



    @endpush

    <style>
        /* Custom scrollbar for webkit browsers */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Animation for notifications */
        @keyframes slideIn {
            from {
                transform: translateY(100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .notification-enter {
            animation: slideIn 0.3s ease-out;
        }
    </style>
</x-admin-app-layout>