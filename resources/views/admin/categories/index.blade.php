<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gradient-to-r from-blue-600 to-purple-600 p-4 rounded-lg shadow-lg">
            <h2 class="font-bold text-3xl text-white tracking-wider">
                {{ __('Product Categories') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12" x-data="{
        search: '{{ request('search') }}',
        status: '{{ request('status') }}',
        perPage: '{{ request('per_page', 10) }}',
        submitFilters() {
            let url = new URL(window.location.href);
            url.searchParams.set('search', this.search);
            url.searchParams.set('status', this.status);
            url.searchParams.set('per_page', this.perPage);
            window.location.href = url.toString();
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">


            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                {{-- Search Bar --}}
                <div class="col-span-1 md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Search Categories') }}
                    </label>
                    <div class="relative">
                        <input
                            type="search"
                            id="search"
                            x-model="search"
                            @keyup.enter="submitFilters()"
                            placeholder="{{ __('Search by ID, name or description') }}"
                            class="w-full pl-12 pr-4 py-3 bg-white dark:bg-gray-800 border-0 rounded-xl
                            text-gray-900 dark:text-white shadow-lg focus:ring-2 focus:ring-blue-500
                            transition-all duration-300 ease-in-out">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                {{-- Add New Category Button --}}
                <div class="flex justify-end mb-0">
                    <a href="{{ route('categories.create') }}" class="inline-flex items-center px-6 py-3
                    bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700
                    text-white font-bold rounded-xl shadow-xl transform hover:scale-105
                    transition-all duration-300 ease-in-out space-x-3 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ __('Add New Category') }}</span>
                    </a>
                </div>
                {{-- Per Page Selector --}}
                <div class="col-span-1">

                </div>
            </div>


            {{-- Categories Table --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-xl shadow-xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gradient-to-r from-blue-500 to-purple-600 text-white">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-bold">{{ __('ID') }}</th>
                                <th scope="col" class="px-6 py-4 font-bold">{{ __('Name') }}</th>
                                <th scope="col" class="px-6 py-4 font-bold">{{ __('Description') }}</th>
                                <th scope="col" class="px-6 py-4 font-bold">{{ __('Image') }}</th>
                                <th scope="col" class="px-6 py-4 font-bold text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700
                                transition duration-300 ease-in-out">
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $category->id }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $category->name }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $category->description }}</td>
                                <td class="px-6 py-4">
                                    <img src="{{ asset('storage/' . $category->image) }}"
                                        alt="{{ $category->name }}"
                                        class="w-20 h-20 object-cover rounded-xl shadow-md
                                         transform hover:scale-110 transition duration-300">
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-center space-x-3">
                                        <a href="{{ route('categories.edit', $category->id) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-green-600 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd" d="M2 16V6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2z" clip-rule="evenodd" />
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('categories.toggle', $category->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm
        {{ $category->status == 'active' ? 'text-red-600 bg-red-100 hover:bg-red-200 focus:ring-red-500' : 'text-green-600 bg-green-100 hover:bg-green-200 focus:ring-green-500' }}
        focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $category->status == 'active' ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900">
                    <div class="flex justify-center">
                        {{ $categories->appends(request()->input())->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
