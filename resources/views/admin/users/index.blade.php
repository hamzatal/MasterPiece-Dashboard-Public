<x-admin-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-900 dark:to-gray-800 p-2 sm:p-4 md:p-6">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="px-3 sm:px-4 md:px-6 py-4 sm:py-6 md:py-8 bg-gradient-to-r from-blue-500 to-purple-600">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7 md:h-8 md:w-8 mr-2 sm:mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                            </svg>
                            Users Management
                        </h1>

                        <a href="{{ route('users.create') }}" class="w-full sm:w-auto flex items-center justify-center space-x-2 px-4 py-2 bg-white dark:bg-gray-700 text-blue-600 dark:text-white rounded-lg shadow-lg hover:bg-blue-50 dark:hover:bg-gray-600 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="font-semibold">Create User</span>
                        </a>
                    </div>
                </div>

                <div class="p-3 sm:p-4 md:p-6">
                    <div class="mb-4 flex flex-col sm:flex-row justify-between items-stretch sm:items-center space-y-4 sm:space-y-0">
                        <form action="{{ route('users.index') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center w-full sm:max-w-md space-y-2 sm:space-y-0">
                            <div class="relative flex-grow">
                                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search users by name or email" class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>

                            <button type="submit" class="w-full sm:w-auto sm:ml-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-sm">
                                Search
                            </button>
                        </form>
                    </div>
                    <div class="mt-2 text-base sm:text-lg font-semibold text-green-500">
                        <p>Total Users: {{ $totalUsers = App\Models\User::count() }}</p>
                    </div><br>

                    <div class="overflow-x-auto -mx-3 sm:-mx-4 md:-mx-6">
                        <div class="inline-block min-w-full align-middle">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-3 sm:px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                </svg>
                                                Name
                                            </div>
                                        </th>
                                        <th class="px-3 sm:px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden sm:table-cell">
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                                </svg>
                                                Email
                                            </div>
                                        </th>
                                        <th class="px-3 sm:px-4 md:px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            <div class="flex items-center justify-end">
                                                Actions
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($users as $user)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                        <td class="px-3 sm:px-4 md:px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs sm:text-sm font-bold">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <div class="ml-3 sm:ml-4">
                                                    <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-gray-200">
                                                        {{ $user->name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 sm:hidden">
                                                        {{ $user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-4 md:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                        </td>
                                        <td class="px-3 sm:px-4 md:px-6 py-4 whitespace-nowrap text-right">
                                            <div class="flex flex-col sm:flex-row justify-end items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-2">
                                                <a href="{{ route('users.view', $user) }}" class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-blue-600 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                    </svg>
                                                    Show
                                                </a>

                                                @if(auth()->user()->role === 'super_admin' || (auth()->user()->role === 'admin' && $user->role === 'user'))
                                                <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-green-600 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                        <path fill-rule="evenodd" d="M2 16V6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2z" clip-rule="evenodd" />
                                                    </svg>
                                                    Edit
                                                </a>
                                                @endif

                                                @if(auth()->user()->role === 'super_admin')
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" id="deleteForm">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        onclick="showDeleteModal()"
                                                        class="w-full sm:w-auto inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-red-400 bg-red-700/20 hover:bg-red-700/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300 ease-in-out transform hover:scale-105">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                                @endif

                                                @if(auth()->user()->role === 'super_admin' || auth()->user()->role === 'admin')
                                                <form action="{{ route('users.toggleActive', $user) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm {{ $user->is_active ? 'text-red-600 bg-red-100 hover:bg-red-200 focus:ring-red-500' : 'text-green-600 bg-green-100 hover:bg-green-200 focus:ring-green-500' }} focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-300">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                        {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Modal for Delete Confirmation -->
                    <div id="deleteModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 hidden">
                        <div class="bg-gray-800 rounded-2xl shadow-2xl border border-gray-700 p-4 sm:p-6 max-w-xs sm:max-w-md w-full mx-4 transform transition-all duration-300 ease-in-out scale-95 opacity-0 modal-content">
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <h3 class="text-base sm:text-lg font-semibold text-red-400">Confirm Deletion</h3>
                            </div>
                            <p class="text-xs sm:text-sm text-gray-300 mb-6">Are you sure you want to delete this user?</p>
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                                <button onclick="deleteUser()" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-300 text-sm">
                                    Yes, Delete User
                                </button>
                                <button onclick="closeModal()" class="w-full px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300 text-sm">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const modalContent = modal.querySelector('.modal-content');

            modal.classList.remove('hidden');

            // Small delay to trigger transition
            setTimeout(() => {
                modal.classList.add('bg-opacity-100');
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('deleteModal');
            const modalContent = modal.querySelector('.modal-content');

            modalContent.classList.add('scale-95', 'opacity-0');
            modalContent.classList.remove('scale-100', 'opacity-100');

            // Wait for transition before hiding
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function deleteUser() {
            document.getElementById('deleteForm').submit();
        }
    </script>
</x-admin-app-layout>