<x-app-layout x-data="{
    darkMode: false,
    copiedCode: null
}">

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Coupons Management</h2>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('coupons.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create Coupon
                    </a>
                </div>
            </div>

            <!-- Filters and Search Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 mb-6">
             <!-- Update the filters section -->
<form action="{{ route('coupons.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <!-- Search -->
    <div class="col-span-1 md:col-span-2">
        <div class="relative">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text"
                name="search"
                value="{{ request('search') }}"
                class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                placeholder="Search coupons...">
        </div>
    </div>

    <!-- Status Filter -->
    <div class="col-span-1">
        <select name="status"
            onchange="this.form.submit()"
            class="w-full border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
            <option value="">All Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <!-- Type Filter -->
    <div class="col-span-1">
        <select name="type"
            onchange="this.form.submit()"
            class="w-full border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
            <option value="">All Types</option>
            <option value="percentage" {{ request('type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
            <option value="fixed" {{ request('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
        </select>
    </div>
</form>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <!-- Total Coupons -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                            <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $coupons->total() }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Coupons</p>
                        </div>
                    </div>
                </div>

                <!-- Active Coupons -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                            <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $activeCoupons ?? 0 }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Active Coupons</p>
                        </div>
                    </div>
                </div>

                <!-- Expired Coupons -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                            <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $expiredCoupons ?? 0 }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Expired Coupons</p>
                        </div>
                    </div>
                </div>

                <!-- Total Usage -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                            <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $totalUsage ?? 0 }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Usage</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coupons Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($coupons as $coupon)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 relative group overflow-hidden"
                    x-data="{ showActions: false, isActive: {{ $coupon->is_active ? 'true' : 'false' }} }">

                    <!-- Status Toggle with Animation -->
                    <div class="absolute top-4 right-4 z-10" x-data="{ isHovered: false }">
                        <form action="{{ route('coupons.toggle-status', $coupon->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" @mouseenter="isHovered = true" @mouseleave="isHovered = false"
                                class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium transition-all duration-300"
                                :class="{
                                    'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300': isActive && !isHovered,
                                    'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300': !isActive && !isHovered,
                                    'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300': isActive && isHovered,
                                    'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300': !isActive && isHovered
                                }"
                                @click.prevent="if(confirm(`Are you sure you want to ${isActive ? 'deactivate' : 'activate'} this coupon?`)) {
                                    isActive = !isActive;
                                    $el.closest('form').submit();
                                }">
                                <svg class="w-3.5 h-3.5 mr-1.5 transition-transform duration-300"
                                    :class="{ 'rotate-180': isHovered }"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path x-show="isActive && !isHovered || !isActive && isHovered" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    <path x-show="!isActive && !isHovered || isActive && isHovered" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span x-text="isActive ? (isHovered ? 'Deactivate' : 'Active') : (isHovered ? 'Activate' : 'Inactive')"></span>
                            </button>
                        </form>
                    </div>

                    <!-- Main Content -->
                    <div class="p-6">
                        <!-- Coupon Header -->
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white tracking-tight group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        {{ $coupon->code }}
                                    </h3>
                                    <button @click="
                                        navigator.clipboard.writeText('{{ $coupon->code }}');
                                        $dispatch('notify', {
                                            message: 'Coupon code copied!',
                                            type: 'success'
                                        });"
                                        class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 p-1 hover:bg-blue-50 dark:hover:bg-blue-900/50 rounded-full"
                                        title="Copy code">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Enhanced Dropdown -->
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button @click="open = !open"
                                    class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                    </svg>
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="open"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-48 rounded-lg shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 z-50 divide-y divide-gray-100 dark:divide-gray-600">
                                    <div class="py-1">
                                        <a href="{{ route('coupons.edit', $coupon->id) }}"
                                            class="group flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>

                                        <!-- Delete Button with Confirmation -->
                                        <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" class="w-full">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="group flex w-full items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/50"
                                                @click.prevent="
                                                    if(confirm('Are you sure you want to delete this coupon? This action cannot be undone.')) {
                                                        $el.closest('form').submit()
                                                    }">
                                                <svg class="mr-3 h-5 w-5 text-red-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Coupon Details -->
                        <div class="space-y-4">
                            <!-- Discount Info with Gradient -->
                            <div class="flex items-center text-sm bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 p-4 rounded-lg">
                                <svg class="w-6 h-6 mr-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                        {{ $coupon->discount_value }}{{ $coupon->discount_type === 'percentage' ? '%' : ' ' . config('app.currency', '$') }}
                                    </span>
                                    <span class="ml-1 text-gray-600 dark:text-gray-300">{{ $coupon->discount_type === 'percentage' ? 'off' : 'discount' }}</span>
                                </div>
                            </div>

                            <!-- Minimum Order Value -->
                            @if($coupon->min_order_value)
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg">
                                <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span>Min. Order: <span class="font-semibold text-gray-900 dark:text-white">{{ config('app.currency', '$') }}{{ number_format($coupon->min_order_value, 2) }}</span></span>
                            </div>
                            @endif

                            <!-- Expiry Date with Dynamic Styling -->
                            @if($coupon->expiry_date)
                            <div class="flex items-center text-sm {{ strtotime($coupon->expiry_date) < time() ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }} bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div class="flex flex-col">
                                    <span>
                                        @if(strtotime($coupon->expiry_date) < time())
                                            <span class="font-medium">Expired:</span> {{ \Carbon\Carbon::parse($coupon->expiry_date)->format('M d, Y') }}
                                    @else
                                    <span class="font-medium">Expires:</span> {{ \Carbon\Carbon::parse($coupon->expiry_date)->format('M d, Y') }}
                                    <span class="text-xs ml-1">({{ \Carbon\Carbon::parse($coupon->expiry_date)->diffForHumans() }})</span>
                                    @endif
                                    </span>
                                </div>
                            </div>
                            @endif

                            <!-- Enhanced Usage Stats with Animation -->
                            @if($coupon->max_uses)
                            <div class="mt-4" x-data="{ showDetails: false }">
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600 dark:text-gray-400">Usage Limit</span>
                                    <span class="font-medium text-gray-900 dark:text-white">
                                        {{ $coupon->usage_count ?? 0 }}/{{ $coupon->max_uses }}
                                    </span>
                                </div>
                                @php
                                $usagePercentage = ($coupon->usage_count / $coupon->max_uses) * 100;
                                $barColor = $usagePercentage > 80 ? 'bg-red-500' : ($usagePercentage > 50 ? 'bg-yellow-500' : 'bg-green-500');
                                @endphp
                                <div class="relative w-full bg-gray-100 rounded-full h-2.5 dark:bg-gray-700 overflow-hidden">
                                    <div class="h-2.5 rounded-full transition-all duration-500 {{ $barColor }}"
                                        style="width: {{ min($usagePercentage, 100) }}%"
                                        @mouseenter="showDetails = true"
                                        @mouseleave="showDetails = false">
                                    </div>
                                    <!-- Tooltip -->
                                    <div x-show="showDetails"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                                        x-transition:enter-end="opacity-100 transform translate-y-0"
                                        class="absolute -top-10 left-1/2 transform -translate-x-1/2 px-3 py-1 text-xs text-white bg-gray-900 rounded-md shadow-lg">
                                        {{ number_format($usagePercentage, 1) }}% used
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Description with Expandable Text -->
                            @if($coupon->description)
                            <div x-data="{ expanded: false }"
                                class="flex items-start text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg mt-4">
                                <svg class="w-5 h-5 mr-3 mt-0.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="flex-1">
                                    <p class="leading-relaxed" :class="{ 'line-clamp-2': !expanded }">
                                        {{ $coupon->description }}
                                    </p>
                                    @if(strlen($coupon->description) > 120)
                                    <button @click="expanded = !expanded"
                                        class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-xs mt-1 focus:outline-none">
                                        <span x-text="expanded ? 'Show less' : 'Show more'"></span>
                                    </button>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <!-- Enhanced Empty State -->
                <div class="col-span-full">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
                        <div class="text-center max-w-sm mx-auto">
                            <!-- Animated Empty State Illustration -->
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 dark:bg-blue-900/50 mb-4 relative overflow-hidden group">
                                <svg class="w-8 h-8 text-blue-500 dark:text-blue-400 transform group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="absolute inset-0 bg-blue-100 dark:bg-blue-800/50 transform -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Coupons Found</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-6">Start creating coupons to offer discounts to your customers.</p>

                            <a href="{{ route('coupons.create') }}"
                                class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm focus:ring-4 focus:ring-blue-500/20">
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create New Coupon
                            </a>

                            <!-- Quick Tips with Hover Effects -->
                            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Quick Tips</h4>
                                <ul class="space-y-3">
                                    <li class="flex items-start text-sm text-gray-500 dark:text-gray-400 group">
                                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 transform group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Set expiration dates to create urgency
                                    </li>
                                    <li class="flex items-start text-sm text-gray-500 dark:text-gray-400 group">
                                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 transform group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Use minimum order values strategically
                                    </li>
                                    <li class="flex items-start text-sm text-gray-500 dark:text-gray-400 group">
                                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 transform group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Track usage with analytics
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Toast Notification Component -->
    <div x-data="{
        notifications: [],
        add(message) {
            this.notifications.push({
                id: Date.now(),
                message,
                show: true
            });
            setTimeout(() => {
                this.remove(this.notifications[0].id);
            }, 3000);
        },
        remove(id) {
            this.notifications = this.notifications.filter(n => n.id !== id);
        }
    }"
        @notify.window="add($event.detail.message)"
        class="fixed bottom-0 right-0 p-4 space-y-4 z-50">
        <template x-for="notification in notifications" :key="notification.id">
            <div x-show="notification.show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="transform translate-x-full opacity-0"
                x-transition:enter-end="transform translate-x-0 opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="transform translate-x-0 opacity-100"
                x-transition:leave-end="transform translate-x-full opacity-0"
                class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span x-text="notification.message"></span>
            </div>
        </template>
    </div>




    <!-- Pagination -->
    <div class="mt-6">
        {{ $coupons->links() }}
    </div>
    </div>
    </div>

    @push('scripts')
    <script>
        function copyToClipboard(text) {
            // Create a temporary input element
            const input = document.createElement('input');
            input.value = text;
            document.body.appendChild(input);

            // Select the text
            input.select();
            input.setSelectionRange(0, 99999);

            // Copy the text
            document.execCommand('copy');

            // Remove the temporary input
            document.body.removeChild(input);

            // Show a toast notification
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-gray-900 text-white px-4 py-2 rounded-lg shadow-lg transform transition-all duration-300 z-50';
            toast.textContent = 'Coupon code copied!';
            document.body.appendChild(toast);

            // Remove the toast after 2 seconds
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 2000);
        }

        // Add event listeners for form submissions
        document.addEventListener('DOMContentLoaded', function() {
            // Status toggle confirmation
            const statusForms = document.querySelectorAll('form[action*="toggle-status"]');
            statusForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const isActive = this.querySelector('button').classList.contains('bg-green-100');
                    const action = isActive ? 'deactivate' : 'activate';
                    if (confirm(`Are you sure you want to ${action} this coupon?`)) {
                        this.submit();
                    }
                });
            });

            // Delete confirmation
            const deleteForms = document.querySelectorAll('form[action*="destroy"]');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (confirm('Are you sure you want to delete this coupon?')) {
                        this.submit();
                    }
                });
            });
        });
    </script>
    @endpush

</x-app-layout>
