<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Success Message -->
                @if(session('success'))
                <div class="mb-4 p-4 text-green-700 bg-green-100 rounded">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Search and Filters -->
                <div class="mb-6 flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <form action="{{ route('categories.index') }}" method="GET" class="w-full">
                            <input
                                type="text"
                                name="search"
                                id="search-categories"
                                placeholder="Search categories..."
                                value="{{ request('search') }}"
                                class="w-full md:w-96 px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300" />
                        </form>
                        <select
                            id="filter-categories"
                            class="px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                            <option value="">All Categories</option>
                            <option value="popular">Popular</option>
                            <option value="new">New Arrivals</option>
                        </select>
                    </div>
                    <!-- Add Category Button -->
                    <a href="{{ route('categories.create') }}" class="flex items-center space-x-2 px-4 py-2 bg-white dark:bg-gray-700 text-blue-600 dark:text-white rounded-lg shadow-lg hover:bg-blue-50 dark:hover:bg-gray-600 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="font-semibold">Add Categories</span>
                    </a>
                </div>

                <!-- Category Grid -->
                <div id="categories-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($categories as $category)
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                        <img
                            src="https://via.placeholder.com/150"
                            alt="Category Image"
                            class="w-full h-32 object-cover rounded-md" />
                        <h3 class="mt-4 text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $category->name }}</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ $category->description ?? 'No description available.' }}
                        </p>
                        <div class="mt-4 flex justify-between">
                            <a href="{{ route('categories.edit', $category->id) }}"
                               class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">Edit</a>

                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">Delete</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $categories->links() }}
                </div>

            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-1/3">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Add Category</h2>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-300">Category Name</label>
                    <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" id="description" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
                <div class="flex justify-between">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Save</button>
                    <button type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400"
                        onclick="document.getElementById('addCategoryModal').classList.add('hidden');">Cancel</button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
