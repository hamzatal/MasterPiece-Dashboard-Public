<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                <!-- Total Users Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-500 bg-opacity-10">
                                <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total Users</h3>
                                <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($totalUsers) }}</p>
                                <p class="mt-1 text-sm {{ $userGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $userGrowth >= 0 ? '↑' : '↓' }} {{ abs(number_format($userGrowth, 1)) }}% from last month
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                                <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Revenue</h3>
                                <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">${{ number_format($currentMonthRevenue) }}</p>
                                <p class="mt-1 text-sm {{ $revenueGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $revenueGrowth >= 0 ? '↑' : '↓' }} {{ abs(number_format($revenueGrowth, 1)) }}% from last month
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Projects Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-500 bg-opacity-10">
                                <svg class="h-8 w-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Active Projects</h3>
                                <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($activeProjects) }}</p>
                                <p class="mt-1 text-sm {{ $projectGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $projectGrowth >= 0 ? '↑' : '↓' }} {{ abs(number_format($projectGrowth, 1)) }}% from last month
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Recent Activities with Notification -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg"
                        x-data="{
                    showNotifications: false,
                    notifications: [],
                    unreadCount: 0,
                    async init() {
                        // Simulate fetching notifications
                        this.notifications = await this.fetchNotifications();
                        this.unreadCount = this.notifications.filter(n => !n.read).length;
                    },
                    async fetchNotifications() {
                        // Replace with your actual API endpoint
                        return [
                            { id: 1, message: 'New project created', time: '5 minutes ago', read: false, type: 'success' },
                            { id: 2, message: 'Task completed', time: '1 hour ago', read: false, type: 'info' },
                            { id: 3, message: 'Meeting scheduled', time: '2 hours ago', read: true, type: 'warning' }
                        ];
                    },
                    markAsRead(id) {
                        const notification = this.notifications.find(n => n.id === id);
                        if (notification && !notification.read) {
                            notification.read = true;
                            this.unreadCount--;
                        }
                    },
                    markAllAsRead() {
                        this.notifications.forEach(n => n.read = true);
                        this.unreadCount = 0;
                    }
                }"
                        @click.away="showNotifications = false">
                        <!-- Notification Bell Header -->
                        <div class="border-b border-gray-200 dark:border-gray-700">
                            <div class="p-4 flex items-center justify-between">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                                    Recent Activities
                                </h3>
                                <div class="relative">
                                    <button @click="showNotifications = !showNotifications"
                                        class="relative p-2 text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white focus:outline-none">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                        <span x-show="unreadCount > 0"
                                            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full"
                                            x-text="unreadCount"></span>
                                    </button>

                                    <!-- Notification Dropdown -->
                                    <div x-show="showNotifications"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 transform scale-95"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        x-transition:leave="transition ease-in duration-100"
                                        x-transition:leave-start="opacity-100 transform scale-100"
                                        x-transition:leave-end="opacity-0 transform scale-95"
                                        class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden z-50">

                                        <!-- Notification Header -->
                                        <div class="p-4 border-b border-gray-200 dark:border-gray-600 flex justify-between items-center">
                                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Notifications</h4>
                                            <button @click="markAllAsRead"
                                                class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                Mark all as read
                                            </button>
                                        </div>

                                        <!-- Notification List -->
                                        <div class="max-h-96 overflow-y-auto">
                                            <template x-for="notification in notifications" :key="notification.id">
                                                <div @click="markAsRead(notification.id)"
                                                    :class="{ 'bg-blue-50 dark:bg-gray-600': !notification.read }"
                                                    class="p-4 border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer">
                                                    <div class="flex items-start">
                                                        <!-- Notification Icon -->
                                                        <div :class="{
                                                    'bg-green-100 text-green-600': notification.type === 'success',
                                                    'bg-blue-100 text-blue-600': notification.type === 'info',
                                                    'bg-yellow-100 text-yellow-600': notification.type === 'warning'
                                                }" class="p-2 rounded-full">
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </div>
                                                        <!-- Notification Content -->
                                                        <div class="ml-3 flex-1">
                                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-200"
                                                                x-text="notification.message"></p>
                                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400"
                                                                x-text="notification.time"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>

                                        <!-- View All Link -->
                                        <a href="#" class="block p-4 text-center text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                            View all notifications
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activity List -->
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($recentActivities as $activity)
                            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <span class="inline-block h-10 w-10 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-600">
                                            <svg class="h-full w-full text-gray-300 dark:text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                            {{ $activity->description }}
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            {{ $activity->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>



            @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Notification Bell Logic
                document.getElementById('notificationBell').addEventListener('click', function() {
                    const dropdown = document.getElementById('notificationDropdown');
                    const badge = document.getElementById('notificationBadge');
                    dropdown.classList.toggle('hidden');
                    badge.classList.add('hidden');
                });

                // Chart Setup - Revenue
                const revenueChartCtx = document.getElementById('revenueChart').getContext('2d');
                new Chart(revenueChartCtx, {
                    type: 'line',
                    data: {
                        labels: ['January', 'February', 'March', 'April', 'May'],
                        datasets: [{
                            label: 'Revenue ($)',
                            data: [3000, 5000, 4000, 6000, 7000],
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Chart Setup - User Growth
                const usersChartCtx = document.getElementById('usersChart').getContext('2d');
                new Chart(usersChartCtx, {
                    type: 'bar',
                    data: {
                        labels: ['January', 'February', 'March', 'April', 'May'],
                        datasets: [{
                            label: 'User Growth',
                            data: [120, 200, 180, 250, 300],
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
            @endpush
</x-app-layout>
