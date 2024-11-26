<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="p-6 bg-gray-50 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">My Profile</h2>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="profile_picture" class="block text-gray-700 font-bold mb-2">Profile Picture</label>
                    <div class="flex items-center">
                        <img
                            src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('/default-avatar.png') }}"
                            alt="Profile Picture"
                            class="w-24 h-24 rounded-full object-cover mr-4"
                        >
                        <input
                            type="file"
                            name="profile_picture"
                            id="profile_picture"
                            class="border border-gray-300 p-2 rounded-lg w-full"
                        >
                    </div>
                    @error('profile_picture')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $user->name) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                    >
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email', $user->email) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                    >
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <button
                        type="submit"
                        class="w-full bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-600 transition duration-300"
                    >
                        Update Profile
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password Section -->
        <div class="bg-white shadow-xl rounded-lg overflow-hidden mt-8">
            <div class="p-6 bg-gray-50 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Change Password</h2>
            </div>

                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="current_password" class="block text-gray-700 font-bold mb-2">Current Password</label>
                    <input
                        type="password"
                        name="current_password"
                        id="current_password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                    >
                    @error('current_password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="new_password" class="block text-gray-700 font-bold mb-2">New Password</label>
                    <input
                        type="password"
                        name="new_password"
                        id="new_password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                    >
                    @error('new_password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="new_password_confirmation" class="block text-gray-700 font-bold mb-2">Confirm New Password</label>
                    <input
                        type="password"
                        name="new_password_confirmation"
                        id="new_password_confirmation"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                    >
                </div>

                <div class="mt-6">
                    <button
                        type="submit"
                        class="w-full bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-600 transition duration-300"
                    >
                        Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
