<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Contact Us') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4">
                    <x-alert type="success" :message="session('success')" />
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4">
                    <x-alert type="error" :message="session('error')" />
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Personal Information Section -->
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Personal Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="name">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Full Name
                                        </div>
                                    </x-input-label>
                                    <x-text-input type="text" name="name" id="name" class="mt-1 block w-full" value="{{ old('name') }}" required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="email">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            Email Address
                                        </div>
                                    </x-input-label>
                                    <x-text-input type="email" name="email" id="email" class="mt-1 block w-full" value="{{ old('email') }}" required />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Contact Details Section -->
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Contact Details</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="phone">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            Phone Number
                                        </div>
                                    </x-input-label>
                                    <x-text-input type="tel" name="phone" id="phone" class="mt-1 block w-full" value="{{ old('phone') }}" />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="department">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            Department
                                        </div>
                                    </x-input-label>
                                    <x-select name="department" id="department" class="mt-1 block w-full">
                                        <option value="">Select Department</option>
                                        <option value="general" {{ old('department') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                                        <option value="sales" {{ old('department') == 'sales' ? 'selected' : '' }}>Sales</option>
                                        <option value="support" {{ old('department') == 'support' ? 'selected' : '' }}>Support</option>
                                        <option value="billing" {{ old('department') == 'billing' ? 'selected' : '' }}>Billing</option>
                                    </x-select>
                                    <x-input-error :messages="$errors->get('department')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Message Section -->
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Message</h3>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <x-input-label for="subject">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            Subject
                                        </div>
                                    </x-input-label>
                                    <x-text-input type="text" name="subject" id="subject" class="mt-1 block w-full" value="{{ old('subject') }}" required />
                                    <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="message">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                            </svg>
                                            Message
                                        </div>
                                    </x-input-label>
                                    <x-textarea name="message" id="message" class="mt-1 block w-full" rows="6" required>{{ old('message') }}</x-textarea>
                                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="attachment">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            Attachment
                                        </div>
                                    </x-input-label>
                                    <x-file-input name="attachment" id="attachment" class="mt-1 block w-full" />
                                    <x-input-error :messages="$errors->get('attachment')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button Section -->
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('contacts.index') }}"
                                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition duration-150">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                                Submit Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contactForm');
            const messageInput = document.getElementById('message');
            const messageCount = document.getElementById('messageCount');
            const fileInput = document.getElementById('attachment');
            const fileInfo = document.getElementById('fileInfo');
            const fileName = document.getElementById('fileName');
            const removeFile = document.getElementById('removeFile');
            const progressBar = document.getElementById('formProgress');

            // Form progress calculation
            function updateProgress() {
                const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
                let filledFields = 0;

                requiredFields.forEach(field => {
                    if (field.value.trim() !== '') {
                        filledFields++;
                    }
                });

                const progress = (filledFields / requiredFields.length) * 100;
                progressBar.style.width = `${progress}%`;
            }

            // Message character count
            messageInput.addEventListener('input', function() {
                const count = this.value.length;
                messageCount.textContent = `${count}/1000 characters`;

                if (count > 1000) {
                    this.value = this.value.substring(0, 1000);
                }

                updateProgress();
            });

            // File handling
            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    fileName.textContent = file.name;
                    fileInfo.classList.remove('hidden');

                    // Validate file size (10MB max)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('File size must be less than 10MB');
                        this.value = '';
                        fileInfo.classList.add('hidden');
                    }
                }
            });

            removeFile.addEventListener('click', function() {
                fileInput.value = '';
                fileInfo.classList.add('hidden');
            });

            // Form validation
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const email = document.getElementById('email').value;
                const phone = document.getElementById('phone').value;

                // Email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    isValid = false;
                    alert('Please enter a valid email address');
                }

                // Phone validation (optional field)
                if (phone !== '') {
                    const phoneRegex = /^\+?[\d\s-()]+$/;
                    if (!phoneRegex.test(phone)) {
                        isValid = false;
                        alert('Please enter a valid phone number');
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });

            // Update progress on any input change
            form.querySelectorAll('input, select, textarea').forEach(element => {
                element.addEventListener('input', updateProgress);
            });

            // Initial progress update
            updateProgress();
        });
    </script>
    @endpush
</x-app-layout>
