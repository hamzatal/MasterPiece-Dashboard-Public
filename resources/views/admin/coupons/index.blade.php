<x-admin-app-layout>
    <!-- Main Container -->
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <!-- Page Header -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="p-8 bg-gradient-to-br from-blue-500/10 via-gray-700/10 to-teal-100/10">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div class="flex items-center gap-5">
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-blue-600 to-teal-300 shadow-lg">
                                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ __('Coupon Management') }}
                                </h1>
                                <p class="mt-2 text-gray-600 dark:text-gray-400 text-lg">
                                    Create and manage your promotional campaigns
                                </p>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('coupons.create') }}" class="inline-flex items-center px-6 py-3 text-lg font-medium text-white bg-gradient-to-r from-blue-600 to-teal-300 rounded-xl shadow-lg hover:shadow-xl transform transition hover:-translate-y-0.5">
                                <svg class="mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                New Coupon
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Search and Filters -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <form method="GET" action="{{ route('coupons.index') }}" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Search Input -->
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="block w-full pl-12 pr-4 py-3 text-base rounded-xl border-gray-200 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Search coupons...">
                            </div>

                            <!-- Status Filter -->
                            <div class="relative">
                                <select name="status" class="block w-full pl-4 pr-10 py-3 text-base rounded-xl border-gray-200 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <!-- Discount Type Filter -->
                            <div class="relative">
                                <select name="discount_type" class="block w-full pl-4 pr-10 py-3 text-base rounded-xl border-gray-200 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">All Discount Types</option>
                                    <option value="percentage" {{ request('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                    <option value="fixed" {{ request('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4">
                            <a href="{{ route('coupons.index') }}" class="inline-flex items-center px-5 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl font-medium transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Reset
                            </a>
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Coupons Grid -->
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        @forelse($coupons as $coupon)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-lg transition-shadow border border-gray-100 dark:border-gray-700 overflow-hidden">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $coupon->code }}</h3>
                                        <p class="mt-1 text-blue-600 dark:text-blue-400 font-medium">
                                            {{ $coupon->discount_type == 'percentage' ? $coupon->discount_value . '%' : '$' . number_format($coupon->discount_value, 2) }} Off
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $coupon->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                        {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>

                                <div class="space-y-3">
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                        <svg class="flex-shrink-0 w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Expires: {{ $coupon->expiry_date ? $coupon->expiry_date->format('M d, Y') : 'No expiry' }}
                                    </div>
                                    @if($coupon->min_order_value)
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                        <svg class="flex-shrink-0 w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Min Order: ${{ number_format($coupon->min_order_value, 2) }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-100 dark:border-gray-600 flex justify-end items-center gap-2">
                                <form action="{{ route('coupons.toggle-status', $coupon) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium {{ $coupon->is_active ? 'bg-red-100 text-red-700 hover:bg-red-200 dark:bg-red-900 dark:text-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200 dark:bg-green-900 dark:text-green-200' }} transition-colors">
                                        {{ $coupon->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>

                                <a href="{{ route('coupons.edit', $coupon) }}" class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 rounded-lg text-sm font-medium transition-colors">
                                    Edit
                                </a>

                                <form action="{{ route('coupons.destroy', $coupon) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-100 text-red-700 hover:bg-red-200 dark:bg-red-900 dark:text-red-200 rounded-lg text-sm font-medium transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full">
                            <div class="flex flex-col items-center justify-center py-16 bg-gray-50 dark:bg-gray-700 rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-600">
                                <div class="p-4 bg-white dark:bg-gray-800 rounded-full shadow-sm">
                                    <svg class="h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">No coupons found</h3>
                                <p class="mt-2 text-gray-500 dark:text-gray-400">Create your first coupon to get started!</p>
                                <div class="mt-6">
                                    <a href="{{ route('coupons.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-teal-300 text-white font-medium rounded-xl transition-all duration-200 transform hover:scale-105 hover:shadow-lg">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Create New Coupon
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Showing {{ $coupons->firstItem() ?? 0 }} to {{ $coupons->lastItem() ?? 0 }} of {{ $coupons->total() ?? 0 }} entries
                        </div>
                        <div class="pagination-container">
                            {{ $coupons->appends(request()->input())->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-admin-app-layout>
