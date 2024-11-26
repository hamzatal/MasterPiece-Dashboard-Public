<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Profile Settings') }}
                </h2>
            </div>

            <span class="px-4 py-2 text-sm text-green-600 bg-green-100 rounded-full dark:bg-green-800/50 dark:text-green-300 flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>Active Account</span>
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Profile Header Card -->
            <div class="bg-gradient-to-br from-white to-gray-100 dark:from-gray-800 dark:to-gray-900 shadow-2xl sm:rounded-2xl overflow-hidden">
                <div class="p-6 flex items-center space-x-8">
                    <div class="relative group">
                        <img class="h-32 w-32 rounded-full object-cover border-4 border-white dark:border-gray-700 transition-transform duration-300 group-hover:scale-105 group-hover:brightness-90"
                             src="{{ auth()->user()->profile_photo_url }}"
                             alt="Profile photo">
                        <button class="absolute bottom-0 right-0 p-2 bg-indigo-600 text-white rounded-full shadow-lg hover:bg-indigo-700 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </button>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->name }}</h3>
                        <p class="text-indigo-600 dark:text-indigo-400 flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            <span>{{ auth()->user()->email }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Profile Information -->
                <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-2xl transform transition-all hover:scale-[1.02]">
                    <div class="p-8">
                        <div class="flex items-center space-x-4 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ __('Profile Information') }}
                            </h3>
                        </div>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Password Update -->
                <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-2xl transform transition-all hover:scale-[1.02]">
                    <div class="p-8">
                        <div class="flex items-center space-x-4 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ __('Update Password') }}
                            </h3>
                        </div>
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="md:col-span-2 bg-white dark:bg-gray-800 shadow-xl sm:rounded-2xl">
                    <div class="p-8">
                        <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-6 rounded-r-2xl mb-6">
                            <div class="flex items-center space-x-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <h3 class="text-xl font-semibold text-red-800 dark:text-red-200">
                                        {{ __('Danger Zone') }}
                                    </h3>
                                    <p class="text-sm text-red-700 dark:text-red-300">
                                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
