<x-admin-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-200 dark:from-gray-900 dark:to-gray-800 transition-all duration-500">
        <div class="container mx-auto px-4 py-12 max-w-7xl">
            <!-- Enhanced Header Section -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-100 dark:border-gray-700 mb-10 overflow-hidden transform hover:scale-[1.01] transition-transform duration-300">
                <div class="p-8 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <div class="flex items-center space-x-6">
                            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                            <h1 class="text-4xl font-bold flex items-center tracking-tight">
                                Order #{{ $order->id }}
                            </h1>
                        </div>
                    </div>

                    <!-- Enhanced Order Details Bar with Advanced Features -->
                    <div class="mt-8 bg-gray-800/50 rounded-xl border border-white/10 shadow-lg overflow-hidden">
                        <div class="flex flex-col md:flex-row justify-between items-center p-6 space-y-4 md:space-y-0">
                            <div class="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-6 w-full">
                                {{-- Status Update Dropdown --}}
                                <div class="w-full md:w-64">
                                    <form action="{{ route('orders.update-status', $order->id) }}" method="POST" class="relative group">
                                        @csrf
                                        @method('PATCH')
                                        <select
                                            name="status"
                                            class="form-select w-full px-4 py-2.5 bg-white/10 text-white border-2 border-white/20 rounded-xl
                               focus:outline-none focus:ring-2 focus:ring-blue-500/70 focus:border-blue-500
                               transition-all duration-300 appearance-none pr-10"
                                            onchange="this.form.submit()">
                                            @php
                                            $statuses = [
                                            'pending' => 'Pending',
                                            'processing' => 'Processing',
                                            'shipped' => 'Shipped',
                                            'delivered' => 'Delivered',
                                            'cancelled' => 'Cancelled'
                                            ];
                                            @endphp
                                            @foreach($statuses as $value => $label)
                                            <option
                                                value="{{ $value }}"
                                                {{ $order->status == $value ? 'selected' : '' }}
                                                class="bg-gray-800 text-white">
                                                {{ $label }}
                                            </option>
                                            @endforeach
                                        </select>

                                        {{-- Custom dropdown arrow --}}
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-white/70">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </form>
                                </div>

                                {{-- Order Creation Date --}}
                                <div class="flex items-center space-x-3 text-white/90">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm tracking-wide">
                                        Created {{ $order->created_at->format('M d, Y h:i A') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Additional Order Information --}}
                            <div class="hidden md:flex items-center space-x-4">
                                {{-- Order ID Badge --}}
                                <div class="bg-white/10 px-3 py-1.5 rounded-lg text-sm text-white/80">
                                    Order #{{ $order->id }}
                                </div>

                                {{-- Status Indicator --}}
                                <div class="flex items-center space-x-2">
                                    @php
                                    $statusColors = [
                                    'pending' => 'bg-yellow-500',
                                    'processing' => 'bg-blue-500',
                                    'shipped' => 'bg-green-500',
                                    'delivered' => 'bg-emerald-600',
                                    'cancelled' => 'bg-red-500'
                                    ];
                                    @endphp
                                    <span class="w-3 h-3 rounded-full {{ $statusColors[$order->status] }}"></span>
                                    <span class="text-sm text-white/90 capitalize">{{ $order->status }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Enhanced Order Items Section -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden transform hover:scale-[1.01] transition-transform duration-300">
                        <div class="p-8 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                Order Items
                            </h2>
                        </div>

                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($order->orderItems ?? [] as $item)
                            <div class="flex flex-col md:flex-row items-start md:items-center p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300 group">
                                <img
                                    src="{{ asset('storage/' . $item->image1) }}"
                                    alt="{{ $item->name }}"
                                    class="w-full md:w-32 h-32 object-cover rounded-2xl mr-0 md:mr-6 shadow-lg group-hover:scale-105 transition-transform duration-300 mb-4 md:mb-0">

                                <div class="flex-grow space-y-4">
                                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white group-hover:text-blue-600 transition-colors duration-300">
                                        {{ $item->name ?? 'Product Name' }}
                                    </h3>
                                    <div class="flex flex-col md:flex-row justify-between space-y-2 md:space-y-0 text-gray-600 dark:text-gray-300">
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                            Quantity: {{ $item->pivot->quantity ?? 0 }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Price: JD {{ number_format($item->pivot->price ?? 0, 2) }}
                                        </span>
                                        <span class="font-bold flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm4 5a.5.5 0 11-1 0 .5.5 0 011 0z" />
                                            </svg>
                                            Total: JD {{ number_format($item->pivot->price * $item->pivot->quantity ?? 0, 2) }}
                                        </span>
                                        <!-- Add color and size -->
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                            </svg>
                                            Color: {{ $item->pivot->color ?? 'N/A' }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                            </svg>
                                            Size: {{ $item-> pivot->size    ?? 'N/A' }}
                                        </span>



                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                No items in this order
                            </div>
                            @endforelse
                        </div>

                        <!-- Enhanced Order Totals -->
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 p-8 border-t border-gray-200 dark:border-gray-700">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center text-2xl font-bold text-blue-600 dark:text-blue-400 border-t dark:border-gray-700 pt-4">
                                    <span class="uppercase tracking-wider">Total</span>
                                    <span>${{ number_format($order->total ?? 0, 2) }}</span>

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Order Timeline Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden transform hover:scale-[1.01] transition-transform duration-300 mt-8">
                        <div class="p-8 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Order Timeline
                            </h2>
                        </div>

                        <div class="p-8">
                            <div class="relative">
                                <!-- Timeline connector line -->
                                <div class="absolute left-8 top-0 h-full w-px bg-gray-200 dark:bg-gray-700"></div>

                                <!-- Timeline steps -->
                                <div class="space-y-8">
                                    <!-- Order Placed -->
                                    <div class="flex items-center space-x-4">
                                        <div class="relative z-10">
                                            <div class="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center shadow-lg">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Order Placed</h3>
                                            <p class="text-gray-500 dark:text-gray-400">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                        </div>
                                    </div>

                                    <!-- Processing -->
                                    @if($order->status == 'processing' || $order->status == 'shipped' || $order->status == 'delivered')
                                    <div class="flex items-center space-x-4">
                                        <div class="relative z-10">
                                            <div class="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center shadow-lg">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Processing</h3>
                                            <p class="text-gray-500 dark:text-gray-400">Your order is being prepared</p>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Shipped -->
                                    @if($order->status == 'shipped' || $order->status == 'delivered')
                                    <div class="flex items-center space-x-4">
                                        <div class="relative z-10">
                                            <div class="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center shadow-lg">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Shipped</h3>
                                            <p class="text-gray-500 dark:text-gray-400">Your order is on its way</p>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Delivered -->
                                    @if($order->status == 'delivered')
                                    <div class="flex items-center space-x-4">
                                        <div class="relative z-10">
                                            <div class="w-16 h-16 rounded-full bg-green-500 flex items-center justify-center shadow-lg">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Delivered</h3>
                                            <p class="text-gray-500 dark:text-gray-400">Your order has been delivered successfully</p>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Cancelled (Optional) -->
                                    @if($order->status == 'cancelled')
                                    <div class="flex items-center space-x-4">
                                        <div class="relative z-10">
                                            <div class="w-16 h-16 rounded-full bg-red-500 flex items-center justify-center shadow-lg">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Order Cancelled</h3>
                                            <p class="text-gray-500 dark:text-gray-400">This order has been cancelled</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Sidebar with Card-Style Sections -->
                <div class="space-y-8">
                    <!-- Enhanced Customer Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden transform hover:scale-[1.01] transition-transform duration-300">
                        <div class="p-6 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-gray-700 dark:to-gray-600">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Customer Details
                            </h2>
                        </div>
                        <div class="p-6">
                            @if($order->user)
                            <div class="flex items-center space-x-4 mb-6">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform duration-300">
                                    <span class="text-white text-xl font-bold">
                                        {{ strtoupper(substr($order->user->name, 0, 2)) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800 dark:text-white text-lg">{{ $order->user->name }}</div>
                                    <div class="text-gray-500 dark:text-gray-300">{{ $order->user->email }}</div>
                                </div>
                            </div>
                            @if($order->user->phone)
                            <div class="flex items-center text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 p-3 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                {{ $order->user->phone }}
                            </div>
                            @endif
                            @else
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                No customer information available
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Enhanced Payment Details Card -->
                    <!-- <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden transform hover:scale-[1.01] transition-transform duration-300">
                        <div class="p-6 bg-gradient-to-r from-green-50 to-green-100 dark:from-gray-700 dark:to-gray-600">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Payment Information
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-6">
                                <div>
                                    <span class="text-gray-600 dark:text-gray-300 block mb-3 font-medium">Payment Status</span>
                                    <span class="
                                        inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold
                                        @if($order->payment_status == 'paid') bg-green-100 text-green-800 dark:bg-green-800/20 dark:text-green-400
                                        @elseif($order->payment_status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-800/20 dark:text-yellow-400
                                        @else bg-red-100 text-red-800 dark:bg-red-800/20 dark:text-red-400
                                        @endif
                                    ">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            @if($order->payment_status == 'paid')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            @elseif($order->payment_status == 'pending')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            @endif
                                        </svg>
                                        {{ ucfirst($order->payment_status ?? 'N/A') }}
                                    </span>
                                </div>
                                @if($order->payment)
                                <div>
                                    <span class="text-gray-600 dark:text-gray-300 block mb-3 font-medium">Transaction ID</span>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl text-sm font-mono break-all">
                                        {{ $order->payment }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div> -->

                    <!-- Enhanced Shipping Details Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden transform hover:scale-[1.01] transition-transform duration-300">
                        <div class="p-6 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-gray-700 dark:to-gray-600">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Shipping Address
                            </h2>
                        </div>
                        <div class="p-6">
                            @if($order->shippingAddress)
                            <div class="space-y-4">
                                <div class="flex items-center mb-4">
                                    <div class="bg-purple-100 dark:bg-purple-800/20 p-3 rounded-xl mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>

                                    </div>
                                    <h3 class="font-semibold text-xl text-gray-800 dark:text-white">
                                        {{ $order->shippingAddress->address_type ?? 'N/A' }}
                                    </h3>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl space-y-2">
                                    <p class="text-gray-600 dark:text-gray-300">
                                        Street Address : {{ $order->shippingAddress->street_address ?? 'N/A' }}<br>
                                        City : {{ $order->shippingAddress->city ?? 'N/A' }},
                                        Country : {{ $order->shippingAddress->country ?? 'N/A' }}
                                    </p>

                                </div>
                            </div>
                            @else
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                No shipping address provided.
                            </div>
                            @endif
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
