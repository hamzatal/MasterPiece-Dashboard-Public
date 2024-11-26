<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                <svg class="w-8 h-8 mr-3 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                {{ __('Discounts Management') }}
            </h2>
            <nav class="flex space-x-4 text-sm">
                <span class="text-gray-400 dark:text-gray-500">Dashboard</span>
                <span class="text-gray-400 dark:text-gray-500">/</span>
                <span class="text-indigo-600 dark:text-indigo-400">Discounts</span>
            </nav>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8" x-data="discountsManagement()">
        <!-- Stats Cards with Modern Design -->

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-indigo-50 dark:bg-indigo-900/50">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Discounts</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $discounts->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-green-50 dark:bg-green-900/50">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Valid Until Today</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">15</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-rose-50 dark:bg-rose-900/50">
                        <svg class="w-6 h-6 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Expiring Soon</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">3</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Discount List with Enhanced Design -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700">
        <!-- Search and Filter Section -->
        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="flex items-center space-x-4">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Discount List</h3>
                    <span class="px-3 py-1 text-xs font-semibold text-indigo-700 dark:text-indigo-400 bg-indigo-100 dark:bg-indigo-900/50 rounded-full">
                        {{ $discounts->count() }} Total
                    </span>
                </div>

                <!-- Actions Section -->
                <div class="flex flex-wrap gap-3 w-full md:w-auto">
                    <div class="relative w-full md:w-64">
                        <input type="text"
                            placeholder="Search discounts..."
                            class="w-full pl-10 pr-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 transition duration-300"
                            x-model="searchQuery">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>

                    <a href="{{ route('discounts.create') }}"
                        class="inline-flex items-center px-4 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition duration-300 space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Add Discount</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Enhanced Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700/30">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Discount Details</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($discounts as $discount)
                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/20 transition duration-150">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <span class="font-medium text-gray-900 dark:text-white">{{ $discount->code }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $discount->discount_type === 'percentage' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-400' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400' }}">
                                    {{ ucfirst($discount->discount_type) }}
                                </span>
                                <span class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ $discount->discount_type === 'percentage' ? $discount->discount_value . '%' : '$' . $discount->discount_value }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('discounts.toggle', $discount->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium transition duration-300
                                        {{ $discount->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400 hover:bg-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400 hover:bg-red-200' }}">
                                    <span class="w-2 h-2 rounded-full mr-2 {{ $discount->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ $discount->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-3">
                                <a href="{{ route('discounts.edit', $discount->id) }}"
                                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 transition duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button onclick="confirmDelete('{{ route('discounts.destroy', $discount->id) }}')"
                                    class="text-red-600 dark:text-red-400 hover:text-red-800 transition duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-6">
            {{ $discounts->links('vendor.pagination.tailwind') }}
        </div>
    </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(deleteUrl) {
            if (confirm('Are you sure you want to delete this discount?')) {
                window.location.href = deleteUrl;
            }
        }

        function discountsManagement() {
            return {
                searchQuery: '',
                init() {
                    // You can add search functionality here
                }
            }
        }
    </script>
    @endpush
</x-app-layout>