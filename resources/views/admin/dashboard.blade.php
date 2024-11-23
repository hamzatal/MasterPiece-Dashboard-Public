<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>



            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
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

                        <!-- Tasks Card -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-red-500 bg-opacity-10">
                                        <svg class="h-8 w-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <div class="ml-5">
                                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Pending Tasks</h3>
                                        <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($pendingTasks) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Revenue Overview -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Revenue Overview</h3>
                                <canvas id="revenueChart" class="mt-4"></canvas>
                            </div>
                        </div>

                        <!-- User Growth -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">User Growth</h3>
                                <canvas id="usersChart" class="mt-4"></canvas>
                            </div>
                        </div>
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
                        </div>
                    </div>
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
