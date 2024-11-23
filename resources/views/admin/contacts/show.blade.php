<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <x-heroicon-o-user-circle class="w-6 h-6 text-gray-600 dark:text-gray-300" />
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('View Contact') }}
                </h2>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('contacts.edit', $contact) }}"
                   class="inline-flex items-center space-x-2 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    <x-heroicon-o-pencil-square class="w-5 h-5" />
                    <span>Edit</span>
                </a>
                <a href="{{ route('contacts.index') }}"
                   class="inline-flex items-center space-x-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    <x-heroicon-o-arrow-left class="w-5 h-5" />
                    <span>Back</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-xl">
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Contact Information Card -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                            <div class="flex items-center space-x-2 mb-6">
                                <x-heroicon-o-identification class="w-6 h-6 text-indigo-500" />
                                <h3 class="text-lg font-semibold">Contact Information</h3>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <x-heroicon-o-user class="w-5 h-5 text-gray-400 mt-1" />
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</p>
                                        <p class="mt-1 font-medium">{{ $contact->name }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <x-heroicon-o-envelope class="w-5 h-5 text-gray-400 mt-1" />
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p>
                                        <p class="mt-1">{{ $contact->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <x-heroicon-o-phone class="w-5 h-5 text-gray-400 mt-1" />
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</p>
                                        <p class="mt-1">{{ $contact->phone ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <x-heroicon-o-building-office class="w-5 h-5 text-gray-400 mt-1" />
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Department</p>
                                        <p class="mt-1">{{ ucfirst($contact->department) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Information Card -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                            <div class="flex items-center space-x-2 mb-6">
                                <x-heroicon-o-clipboard-document-check class="w-6 h-6 text-indigo-500" />
                                <h3 class="text-lg font-semibold">Status Information</h3>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <x-heroicon-o-signal class="w-5 h-5 text-gray-400 mt-1" />
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</p>
                                        <p class="mt-1">
                                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                                @if($contact->status === 'new') bg-blue-100 text-blue-800
                                                @elseif($contact->status === 'in_progress') bg-yellow-100 text-yellow-800
                                                @elseif($contact->status === 'resolved') bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ str_replace('_', ' ', ucfirst($contact->status)) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <x-heroicon-o-flag class="w-5 h-5 text-gray-400 mt-1" />
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Priority</p>
                                        <p class="mt-1">
                                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                                @if($contact->priority === 'high') bg-red-100 text-red-800
                                                @elseif($contact->priority === 'medium') bg-yellow-100 text-yellow-800
                                                @else bg-green-100 text-green-800
                                                @endif">
                                                {{ ucfirst($contact->priority) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <x-heroicon-o-clock class="w-5 h-5 text-gray-400 mt-1" />
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</p>
                                        <p class="mt-1">{{ $contact->created_at->format('F j, Y g:i A') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <x-heroicon-o-arrow-path class="w-5 h-5 text-gray-400 mt-1" />
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Updated At</p>
                                        <p class="mt-1">{{ $contact->updated_at->format('F j, Y g:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Message Card -->
                        <div class="md:col-span-2">
                            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                <div class="flex items-center space-x-2 mb-4">
                                    <x-heroicon-o-chat-bubble-left-ellipsis class="w-6 h-6 text-indigo-500" />
                                    <h3 class="text-lg font-semibold">Message</h3>
                                </div>
                                <div class="bg-white dark:bg-gray-600 p-4 rounded-lg">
                                    {{ $contact->message }}
                                </div>
                            </div>
                        </div>

                        <!-- Response Card (if exists) -->
                        @if($contact->response)
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                    <div class="flex items-center space-x-2 mb-4">
                                        <x-heroicon-o-chat-bubble-left-right class="w-6 h-6 text-indigo-500" />
                                        <h3 class="text-lg font-semibold">Response</h3>
                                    </div>
                                    <div class="bg-white dark:bg-gray-600 p-4 rounded-lg">
                                        {{ $contact->response }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Attachment Card (if exists) -->
                        @if($contact->attachment)
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                    <div class="flex items-center space-x-2 mb-4">
                                        <x-heroicon-o-paper-clip class="w-6 h-6 text-indigo-500" />
                                        <h3 class="text-lg font-semibold">Attachment</h3>
                                    </div>
                                    <div class="bg-white dark:bg-gray-600 p-4 rounded-lg">
                                        <a href="{{ Storage::url($contact->attachment) }}"
                                           class="inline-flex items-center space-x-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                                           target="_blank">
                                            <x-heroicon-o-arrow-down-tray class="w-5 h-5" />
                                            <span>Download Attachment</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
