<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <!-- Profile Image -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md max-w-md mx-auto">
            <div class="flex flex-col items-center space-y-6">
                <!-- Image Preview Container -->
                <div class="relative">
                    <input
                        type="file"
                        name="image"
                        id="profileImageInput"
                        accept="image/png,image/jpeg,image/jpg,image/gif"
                        class="hidden"
                        onchange="previewImage(this)">
                    <div class="relative">
                        <!-- Profile Image Preview -->
                        <img
                            id="imagePreview"
                            src="/default-avatar.png"
                            alt="Profile Preview"
                            class="w-32 h-32 rounded-full object-cover border-4 border-teal-500 shadow-md transition-transform duration-300 hover:scale-105">

                        <!-- Overlay for Image Upload -->
                        <label
                            for="profileImageInput"
                            class="absolute bottom-0 right-0 bg-teal-500 text-white p-2 rounded-full cursor-pointer hover:bg-teal-600 transition-colors duration-300 shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </label>
                    </div>
                </div>

                <!-- File Upload Information -->
                <div class="text-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">
                        Upload Profile Picture
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        Choose a square image (400x400 px recommended)
                    </p>

                    <!-- File Details -->
                    <div id="fileDetails" class="text-xs text-gray-500 dark:text-gray-400 space-y-1">
                        <p>Allowed formats: PNG, JPG, JPEG, GIF</p>
                        <p>Max file size: 2MB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
        </div>

        <!-- Phone Number -->
        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
            <p class="mt-1 text-sm text-blue-600">{{ __('Example: 077XXXXXX - 079XXXXXX - 078XXXXXX') }}</p>
        </div>



        <!-- Submit Button -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Changes') }}</x-primary-button>

            @if (session('status') === 'profile-image')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600">
                {{ __('Profile image updated successfully.') }}
            </p>
            @endif
        </div>
    </form>
</section>
<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const fileDetails = document.getElementById('fileDetails');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const fileType = file.type;
            const fileSize = file.size;

            // Validate file type
            const validTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
            if (!validTypes.includes(fileType)) {
                alert('Invalid file type. Please choose a PNG, JPG, JPEG, or GIF image.');
                input.value = ''; // Clear the input
                return;
            }

            // Validate file size (2MB = 2 * 1024 * 1024 bytes)
            if (fileSize > 2 * 1024 * 1024) {
                alert('File is too large. Maximum size is 2MB.');
                input.value = ''; // Clear the input
                return;
            }

            // Read and display image
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                fileDetails.innerHTML = `
                    <p>File: ${file.name}</p>
                    <p>Size: ${(fileSize / 1024).toFixed(2)} KB</p>
                `;
            }
            reader.readAsDataURL(file);
        }
    }
</script>