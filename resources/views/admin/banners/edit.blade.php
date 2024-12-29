<x-admin-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-8 flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('dashboard') }}" class="hover:text-purple-600 dark:hover:text-purple-400">Dashboard</a>
                <span class="text-gray-300 dark:text-gray-600">/</span>
                <a href="{{ route('banners.index') }}" class="hover:text-purple-600 dark:hover:text-purple-400">Banners</a>
                <span class="text-gray-300 dark:text-gray-600">/</span>
                <span class="text-gray-700 dark:text-gray-300">Edit</span>
            </nav>

            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-100 dark:border-gray-700">
                <!-- Header -->
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-5">
                            <div class="p-3 bg-gradient-to-br from-purple-100 to-blue-100 dark:from-purple-900 dark:to-blue-900 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-500 bg-clip-text text-transparent">
                                    Edit Banner
                                </h1>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Update your banner information and visuals
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="px-3 py-1 text-xs font-medium {{ $banner->active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} rounded-full">
                                {{ $banner->active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('banners.update', $banner->id) }}" enctype="multipart/form-data" class="p-8 space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                        <!-- Left Column -->
                        <div class="space-y-8">
                            <!-- Title -->
                            <div class="space-y-2">
                                <label for="title" class="text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                                <input
                                    type="text"
                                    name="title"
                                    id="title"
                                    value="{{ old('title', $banner->title) }}"
                                    class="w-full px-4 py-3 rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    placeholder="Enter compelling banner title">
                                @error('title')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="space-y-2">
                                <label for="description" class="text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea
                                    name="description"
                                    id="description"
                                    rows="4"
                                    class="w-full px-4 py-3 rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    placeholder="Enter banner description">{{ old('description', $banner->description) }}</textarea>
                                @error('description')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Settings -->
                            <div class="space-y-4 p-6 bg-gray-600 dark:bg-gray-750 rounded-xl">
                                <h3 class="font-medium text-gray-900 dark:text-gray-100">Banner Settings</h3>

                                <!-- Status Toggle -->
                                <div class="flex items-center justify-between">
                                    <label for="active" class="text-sm text-gray-700 dark:text-gray-100">Active Status</label>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input
                                            type="checkbox"
                                            name="active"
                                            id="active"
                                            class="sr-only peer"
                                            {{ $banner->active ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-purple-600"></div>
                                    </label>
                                </div>

                                <!-- Location -->
                                <div class="space-y-2">
                                    <label class="text-sm text-gray-700 dark:text-gray-100">Banner Location</label>
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center">
                                            <input
                                                type="radio"
                                                name="is_homepage"
                                                id="location_hero"
                                                value="hero"
                                                {{ $banner->is_homepage === 'hero' ? 'checked' : '' }}
                                                class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="location_hero" class="ml-2 text-sm text-gray-700 dark:text-gray-100">Hero Section</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input
                                                type="radio"
                                                name="is_homepage"
                                                id="location_discounted"
                                                value="discounted_section"
                                                {{ $banner->is_homepage === 'discounted_section' ? 'checked' : '' }}
                                                class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="location_discounted" class="ml-2 text-sm text-gray-700 dark:text-gray-100">Discounted Section</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Right Column -->
                        <div class="space-y-8">
                            <!-- Image Upload -->
                            <div x-data="{
    imagePreview: '{{ $banner->image ? Storage::url($banner->image) : null }}',
    handleImageUpload(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imagePreview = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    },
    removeImage() {
        this.imagePreview = null;
        const fileInput = this.$refs.imageInput;
        fileInput.value = '';

        if (@json($banner->image !== null)) {
            const removeInput = document.createElement('input');
            removeInput.type = 'hidden';
            removeInput.name = 'remove_image';
            removeInput.value = '1';
            this.$refs.imageContainer.appendChild(removeInput);
        }
    }
}" class="space-y-4">
    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Banner Image</label>

    <div x-ref="imageContainer" class="relative aspect-square rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-gray-400 transition-colors">
        <!-- File Input -->
        <input
            x-ref="imageInput"
            type="file"
            name="image"
            accept="image/jpeg,image/png,image/webp"
            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
            @change="handleImageUpload($event)">

        <!-- Upload Placeholder -->
        <div
            class="absolute inset-0 flex flex-col items-center justify-center"
            x-show="!imagePreview"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Click to upload image</p>
            <p class="mt-1 text-xs text-gray-400">PNG, JPG, WEBP up to 2MB</p>
        </div>

        <!-- Image Preview -->
        <template x-if="imagePreview">
            <div class="relative h-full">
                <img
                    :src="imagePreview"
                    class="absolute inset-0 w-full h-full object-cover rounded-xl"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100">

                <!-- Hover Overlay -->
                <div
                    class="absolute inset-0 bg-black bg-opacity-40 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center rounded-xl">
                    <button
                        type="button"
                        @click.prevent="removeImage()"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Remove Image
                    </button>
                </div>
            </div>
        </template>
    </div>

    @error('image')
    <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 mt-6 border-t border-gray-100 dark:border-gray-700">
                        <a
                            href="{{ route('banners.index') }}"
                            class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                            Cancel
                        </a>
                        <button
                            type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-500 hover:from-purple-700 hover:to-blue-600 text-white rounded-xl transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            Update Banner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                const preview = document.getElementById('preview');
                const previewContainer = document.getElementById('imagePreview');
                const existingImage = document.getElementById('existingImage');

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    if (existingImage) {
                        existingImage.classList.add('hidden');
                    }
                }

                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            const input = document.getElementById('image');
            const preview = document.getElementById('imagePreview');
            const existingImage = document.getElementById('existingImage');

            input.value = '';
            preview.classList.add('hidden');
            if (existingImage) {
                existingImage.classList.remove('hidden');
            }
        }

        function removeExistingImage() {
            const existingImage = document.getElementById('existingImage');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remove_image';
            input.value = '1';
            existingImage.parentNode.appendChild(input);
            existingImage.classList.add('hidden');
        }

        // Add drag and drop functionality
        const dropZone = document.querySelector('.border-dashed');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('border-purple-500');
        }

        function unhighlight(e) {
            dropZone.classList.remove('border-purple-500');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            const input = document.getElementById('image');

            input.files = files;
            previewImage({
                target: input
            });
        }
    </script>
</x-admin-app-layout>
