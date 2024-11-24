<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Profile Settings') }}
            </h2>
            <span class="px-4 py-2 text-sm text-green-600 bg-green-100 rounded-full dark:bg-green-800 dark:text-green-100">
                Active Account
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile Header Card -->
            <div class="mb-8 p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex items-center space-x-6">
                    <div class="relative">
                        <img class="h-24 w-24 rounded-full object-cover border-4 border-white dark:border-gray-700"
                             src="{{ auth()->user()->profile_photo_url }}"
                             alt="Profile photo">
                        <button class="absolute bottom-0 right-0 p-1.5 bg-gray-800 dark:bg-gray-700 rounded-full text-white hover:bg-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </button>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->name }}</h3>
                        <p class="text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Profile Information -->
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">
                            {{ __('Profile Information') }}
                        </h3>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Password Update -->
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">
                            {{ __('Update Password') }}
                        </h3>
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="md:col-span-2 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="p-6">
                        <div class="border-l-4 border-red-500 p-4 bg-red-50 dark:bg-red-900/20">
                            <h3 class="text-lg font-medium text-red-800 dark:text-red-200">
                                {{ __('Danger Zone') }}
                            </h3>
                            <p class="mt-1 text-sm text-red-700 dark:text-red-300">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
                            </p>
                        </div>
                        <div class="mt-6">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
