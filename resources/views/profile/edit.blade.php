@if (Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin')
<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-600 to-purple-700">
            <div class="flex items-center space-x-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <h1 class="text-3xl font-bold text-white">{{ __('My Profile') }}</h1>
            </div>
        </div>
    </x-slot>

    <!-- Rest of the original content remains the same -->
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow-2xl rounded-2xl overflow-hidden">
            <!-- Profile Header with Image Upload -->
            <div class="relative bg-gradient-to-r from-blue-500 to-purple-600 p-8">
                <div class="absolute top-4 right-4">
                    @if(auth()->user()->is_active)
                    <span class="px-4 py-2 bg-green-500 text-white rounded-full flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Active</span>
                    </span>
                    @else
                    <span class="px-4 py-2 bg-red-500 text-white rounded-full flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <span>Inactive</span>
                    </span>
                    @endif
                </div>

                <div class="flex items-center space-x-6">
                    <div class="relative group">
                        <input
                            type="file"
                            id="profileImageUpload"
                            class="hidden"
                            accept="image/png,image/jpeg,image/jpg,image/gif"
                            onchange="updateProfileImage(this)">
                        <label for="profileImageUpload" class="cursor-pointer">
                            <img
                                class="h-40 w-40 rounded-full object-cover border-4 border-white shadow-lg group-hover:brightness-75 transition-all duration-300"
                                src="{{ auth()->user()->image }}"
                                alt="{{ auth()->user()->name }}'s profile photo">
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </label>
                    </div>

                    <div>
                        <h2 class="text-4xl font-bold text-white mb-2">{{ auth()->user()->name }}</h2>
                        <div class="flex items-center space-x-4 text-white/80">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                <span>{{ auth()->user()->email }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                <span>{{ auth()->user()->phone ?? 'Not provided' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Rest of the original content -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-8">
                <!-- Update Profile Information -->
                <div class="bg-gray-100 dark:bg-gray-700 rounded-xl p-6 hover:shadow-lg transition-all">
                    <div class="flex items-center space-x-4 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <h3 class="text-xl font-semibold">Update Profile</h3>
                    </div>
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- Change Password -->
                <div class="bg-gray-100 dark:bg-gray-700 rounded-xl p-6 hover:shadow-lg transition-all">
                    <div class="flex items-center space-x-4 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <h3 class="text-xl font-semibold">Change Password</h3>
                    </div>
                    @include('profile.partials.update-password-form')
                </div>

                <!-- Danger Zone -->
                <div class="md:col-span-2 bg-red-50 dark:bg-red-900/20 rounded-xl p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <h3 class="text-xl font-semibold text-red-800 dark:text-red-200">Danger Zone</h3>
                    </div>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateProfileImage(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const validTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];

                // Validate file type
                if (!validTypes.includes(file.type)) {
                    alert('Please upload a valid image (PNG, JPG, JPEG, GIF)');
                    input.value = ''; // Clear the input
                    return;
                }

                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File is too large. Maximum size is 2MB.');
                    input.value = ''; // Clear the input
                    return;
                }

                // Create FileReader to preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('img[alt="{{ auth()->user()->name }}\'s profile photo"]').src = e.target.result;
                }
                reader.readAsDataURL(file);

                // Here you would typically send the file to the server
                // This would be done via AJAX or form submission
                // Example:
                // const formData = new FormData();
                // formData.append('profile_image', file);
                // fetch('/upload-profile-image', {
                //     method: 'POST',
                //     body: formData
                // });
            }
        }
    </script>
</x-admin-app-layout>
@else
<x-ecommerce-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    <main class="main__content_wrapper">

        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">My Account</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">My Account</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- Profile Section -->
        <section class="profile">
            <div class="profile__layout">
                <div class="profile__content">
                    <!-- Profile Update Section -->
                    <div class="profile__block">
                        <div class="profile__header">
                            <h2 class="profile__title">Profile Settings</h2>
                        </div>

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="profile__form">
                            @csrf
                            @method('PATCH')

                            <div class="profile__grid">
                                <!-- Profile Picture Column -->
                                <div class="profile__avatar">
                                    <label for="profileImageUpload" class="profile__avatar-label">
                                        <img class="profile__avatar-img" src="{{ auth()->user()->image ? auth()->user()->image : asset('logo2.png') }}" alt="{{ auth()->user()->name }}'s profile photo">
                                        <div class="profile__avatar-overlay">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="profile__avatar-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                    </label>
                                    <input type="file" id="profileImageUpload" class="profile__avatar-input" name="image" accept="image/*">
                                </div>

                                <!-- Profile Details Column -->
                                <div class="profile__details">
                                    <div class="profile__form-grid">
                                        <div class="profile__input-group">
                                            <label for="name" class="profile__label">Full Name</label>
                                            <div class="profile__input-field">
                                                <i class="fas fa-user profile__input-icon"></i>
                                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="profile__input">
                                            </div>
                                        </div>

                                        <div class="profile__input-group">
                                            <label for="email" class="profile__label">Email Address</label>
                                            <div class="profile__input-field">
                                                <i class="fas fa-envelope profile__input-icon"></i>
                                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="profile__input">
                                            </div>
                                        </div>

                                        <div class="profile__input-group">
                                            <label for="phone" class="profile__label">Phone Number</label>
                                            <div class="profile__input-field">
                                                <i class="fas fa-phone profile__input-icon"></i>
                                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="profile__input">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile__actions">
                                        <button type="submit" class="profile__submit-btn">
                                            <i class="fas fa-save profile__submit-icon"></i>Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Password Change Section -->
                    <div class="profile__block">
                        <div class="profile__header">
                            <h2 class="profile__title">Security Settings</h2>
                        </div>

                        <form method="post" action="{{ route('password.update') }}" class="profile__form">
                            @csrf
                            @method('put')

                            <div class="profile__form-grid">
                                <div class="profile__input-group">
                                    <label for="current_password" class="profile__label">Current Password</label>
                                    <div class="profile__input-field">
                                        <i class="fas fa-lock profile__input-icon"></i>
                                        <input type="password" id="current_password" name="current_password" class="profile__input">
                                    </div>
                                </div>

                                <div class="profile__input-group">
                                    <label for="password" class="profile__label">New Password</label>
                                    <div class="profile__input-field">
                                        <i class="fas fa-key profile__input-icon"></i>
                                        <input type="password" id="password" name="password" class="profile__input">
                                    </div>
                                </div>

                                <div class="profile__input-group">
                                    <label for="password_confirmation" class="profile__label">Confirm Password</label>
                                    <div class="profile__input-field">
                                        <i class="fas fa-key profile__input-icon"></i>
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="profile__input">
                                    </div>
                                </div>

                                <div class="profile__actions">
                                    <button type="submit" class="profile__submit-btn">
                                        <i class="fas fa-save profile__submit-icon"></i>Update Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Account Deletion Section -->
                    <div class="profile__block profile__block--danger">
                        <div class="profile__header">
                            <h2 class="profile__title">Danger Zone</h2>
                        </div>
                        <div class="profile__warning-message">
                            <p>Once you delete your account, there is no going back. Please be certain.</p>
                        </div>
                        <form method="post" action="{{ route('profile.destroy') }}" class="profile__form">
                            @csrf
                            @method('delete')

                            <div class="profile__form-grid">
                                <div class="profile__input-group">
                                    <label for="password" class="profile__label">Confirm Password</label>
                                    <div class="profile__input-field">
                                        <i class="fas fa-lock profile__input-icon"></i>
                                        <input type="password" id="password" name="password" class="profile__input" placeholder="Enter your password to confirm deletion">
                                    </div>
                                </div>

                                <div class="profile__actions">
                                    <button type="submit" class="profile__delete-btn">
                                        <i class="fas fa-trash profile__submit-icon"></i>Delete Account
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <style>
            /* Modern Profile Page Styles */
            :root {
                --primary-color: #4f46e5;
                --primary-hover: #4338ca;
                --danger-color: #ef4444;
                --danger-hover: #dc2626;
                --bg-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
                --surface-color: #ffffff;
                --text-primary: #1f2937;
                --text-secondary: #6b7280;
                --border-color: #e5e7eb;
                --input-bg: #f9fafb;
            }

            /* Profile Layout */
            .profile__layout {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 1.5rem;
            }

            .profile__content {
                display: flex;
                flex-direction: column;
                gap: 2rem;
            }

            .profile__block {
                background: var(--surface-color);
                border-radius: 1rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                padding: 2rem;
                transition: transform 0.2s, box-shadow 0.2s;
            }

            .profile__block:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }

            .profile__header {
                margin-bottom: 2rem;
                padding-bottom: 1rem;
                border-bottom: 2px solid var(--border-color);
            }

            .profile__title {
                font-size: 1.5rem;
                font-weight: 600;
                color: var(--text-primary);
            }

            /* Avatar Section */
            .profile__avatar {
                position: relative;
                width: 150px;
                height: 150px;
                margin: 0 auto 2rem;
            }

            .profile__avatar-img {
                width: 100%;
                height: 100%;
                border-radius: 50%;
                object-fit: cover;
                border: 4px solid var(--surface-color);
                box-shadow: 0 0 0 4px var(--primary-color);
            }

            .profile__avatar-overlay {
                position: absolute;
                inset: 0;
                border-radius: 50%;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.2s;
            }

            .profile__avatar-label:hover .profile__avatar-overlay {
                opacity: 1;
            }

            .profile__avatar-icon {
                width: 2rem;
                height: 2rem;
                color: white;
            }

            .profile__avatar-input {
                display: none;
            }

            /* Form Styles */
            .profile__form-grid {
                display: grid;
                gap: 1.5rem;
            }

            .profile__input-group {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .profile__label {
                font-weight: 500;
                color: var(--text-primary);
            }

            .profile__input-field {
                position: relative;
            }

            .profile__input-icon {
                position: absolute;
                left: 0.7rem;
                top: 50%;
                transform: translateY(-50%);
                color: var(--text-secondary);
                pointer-events: none;

            }

            .profile__input {
                width: 100%;
                padding: 0.75rem 1rem 0.75rem 2.5rem;
                border: 1px solid var(--border-color);
                border-radius: 0.5rem;
                background: var(--input-bg);
                transition: border-color 0.2s, box-shadow 0.2s;
            }

            .profile__input:focus {
                outline: none;
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            }

            /* Buttons */
            .profile__actions {
                margin-top: 2rem;
                display: flex;
                justify-content: flex-end;
            }

            .profile__submit-btn {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.75rem 1.5rem;
                background: var(--primary-color);
                color: white;
                border: none;
                border-radius: 0.5rem;
                font-weight: 500;
                cursor: pointer;
                transition: background-color 0.2s;
            }

            .profile__submit-btn:hover {
                background: var(--primary-hover);
            }

            .profile__delete-btn {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.75rem 1.5rem;
                background: var(--danger-color);
                color: white;
                border: none;
                border-radius: 0.5rem;
                font-weight: 500;
                cursor: pointer;
                transition: background-color 0.2s;
            }

            .profile__delete-btn:hover {
                background: var(--danger-hover);
            }

            /* Danger Zone */
            .profile__block--danger {
                border: 2px solid var(--danger-color);
            }

            .profile__warning-message {
                padding: 1rem;
                background: #fee2e2;
                border-radius: 0.5rem;
                color: var(--danger-color);
                margin-bottom: 1.5rem;
            }

            /* Responsive Design */
            @media (min-width: 768px) {
                .profile__grid {
                    display: grid;
                    grid-template-columns: auto 1fr;
                    gap: 2rem;
                    align-items: start;
                }

                .profile__form-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 767px) {
                .breadcrumb__content--title {
                    font-size: 2rem;
                }

                .profile__block {
                    padding: 1.5rem;
                }

                .profile__avatar {
                    width: 120px;
                    height: 120px;
                }
            }
        </style>

        <script>
            // JavaScript to handle image preview
            document.getElementById('profileImageUpload').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.querySelector('.profile__avatar-img');
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>

    </main>
</x-ecommerce-app-layout>
@endif