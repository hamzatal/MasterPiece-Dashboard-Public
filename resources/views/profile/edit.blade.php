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
    <style>
        /* Custom CSS */
        :root {
            --primary-red: #e31837;
            --dark-red: #b31329;
            --off-white: #f8f9fa;
            --btn-hover-bg: #dc3545;
            --input-border-focus: #e31837;
        }

        .account__welcome--text {
            font-size: 1.5rem;
            margin-bottom: 30px;
            color: #333;
            text-align: center;
            font-weight: 500;
        }

        .account__wrapper {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
        }

        .account__content {
            margin-bottom: 40px;
        }

        .account__content--title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .account__content--title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary-red);
        }

        /* Profile Image Styles */
        .profile-image-container {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 0 auto 30px;
        }

        .profile-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid var(--primary-red);
            transition: all 0.3s ease;
        }

        .profile-image-label {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: var(--primary-red);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .profile-image-label:hover {
            background: var(--dark-red);
            transform: scale(1.1);
        }

        /* Form Styles */
        .form-control {
            border: 2px solid #e1e1e1;
            padding: 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--input-border-focus);
            box-shadow: 0 0 0 0.2rem rgba(227, 24, 55, 0.25);
        }

        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        /* Danger Zone Styles */
        .danger-zone {
            background: #fff5f5;
            border: 1px solid #feb2b2;
            border-radius: 12px;
            padding: 25px;
        }

        .danger-zone h2 {
            color: #dc3545;
        }

        /* Button Styles */
        .btn {
            border-radius: 8px;
            padding: 12px 20px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .primary__btn {
            background-color: var(--primary-red);
            color: white;
        }

        .primary__btn:hover {
            background-color: var(--btn-hover-bg);
        }

        .danger-zone .btn:hover {
            background-color: var(--dark-red);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .account__wrapper {
                padding: 20px;
            }

            .profile-image-container {
                width: 150px;
                height: 150px;
            }
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><span>Home</span></li>
                            <li class="breadcrumb__content--menu__items"><span>My Account</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- Profile Section -->
    <section class="my__account--section section--padding">
        <div class="container">
            <div class="account__wrapper">
                <!-- Profile Update Form -->
                <div class="account__content">
                    <h2 class="account__content--title h3">Update Your Profile</h2>
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <!-- Profile Picture -->
                            <div class="col-md-4 text-center">
                                <div class="profile-image-container">
                                    <img id="profile-image"
                                        src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('default-profile.png') }}"
                                        alt="Profile Picture">
                                    <label for="image-input" class="profile-image-label">
                                        <i class="fas fa-camera"></i>
                                        <input type="file" name="image" id="image-input" class="d-none">
                                    </label>
                                </div>
                            </div>

                            <!-- Profile Details -->
                            <div class="col-md-8">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="name">Full Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="email">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="phone">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                        </div>
                                    </div>

                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn primary__btn">
                                            <i class="fas fa-save me-2"></i>Update Profile
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Password Change Section -->
                <div class="account__content">
                    <h2 class="account__content--title h3">Change Password</h2>
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label" for="current_password">Current Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="current_password" name="current_password">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label" for="password">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label" for="password_confirmation">Confirm New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="btn primary__btn">
                                    <i class="fas fa-save me-2"></i>Change Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Danger Zone Section -->
                <div class="account__content danger-zone">
                    <h2 class="h3">Delete Account</h2>
                    <p>Deleting your account will remove all of your data permanently. This action is irreversible.</p>
                    <form method="POST" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Delete Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-ecommerce-app-layout>

@endif
