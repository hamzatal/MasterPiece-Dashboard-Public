<x-admin-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Enhanced Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 w-full md:w-auto">
                    <div class="p-2 sm:p-3 bg-purple-100 dark:bg-purple-900 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8 text-purple-600 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold bg-gradient-to-r from-purple-600 to-blue-500 bg-clip-text text-transparent">
                            Banner Management
                        </h1>
                        <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 mt-1">Manage your website banners and promotional content</p>
                    </div>
                </div>
                <button
                    x-data=""
                    x-on:click="$store.bannerForm.toggleForm()"
                    class="w-full md:w-auto mt-4 md:mt-0 group flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-purple-600 to-blue-500 hover:from-purple-700 hover:to-blue-600 text-white rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Banner
                </button>
            </div>

            <!-- Enhanced Success Message -->
            @if(session('success'))
            <div class="mb-4 sm:mb-6 bg-green-50 dark:bg-green-900/50 border-l-4 border-green-500 p-3 sm:p-4 rounded-r-xl animate-fade-in-down">
                <div class="flex items-center">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-green-500 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm sm:text-base text-green-800 dark:text-green-200">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <!-- Create/Edit Form -->
            <div x-data="{
                show: false,
                image: null,
                imagePreview: null,
                errors: {},
                handleImageUpload(event) {
                    const file = event.target.files[0];
                    if (file) {
                        if (file.size > 4048576) {
                            this.errors.image = 'Image must be less than 4MB';
                            event.target.value = '';
                            return;
                        }
                        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
                            this.errors.image = 'Image must be in JPG, PNG, or WEBP format';
                            event.target.value = '';
                            return;
                        }
                        this.image = file;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.imagePreview = e.target.result;
                        };
                        reader.readAsDataURL(file);
                        this.errors.image = null;
                    }
                },
                validateForm() {
                    this.errors = {};
                    let isValid = true;
                    return isValid;
                }
            }"
                x-show="$store.bannerForm.isOpen"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-4"
                class="mb-6 sm:mb-8 bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-4 sm:p-6 border border-gray-100 dark:border-gray-700">

                <form
                    x-bind:action="isEditing ? '{{ route('banners.update', ':id') }}'.replace(':id', editBanner ? editBanner.id : '') : '{{ route('banners.store') }}'"
                    method="POST"
                    enctype="multipart/form-data"
                    @submit.prevent="if(validateForm()) $el.submit()"
                    class="space-y-4 sm:space-y-6">
                    @csrf

                    <!-- Form Header -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white" x-text="isEditing ? 'Edit Banner' : 'Add New Banner'"></h3>
                        <p class="mt-1 text-xs sm:text-sm text-gray-500 dark:text-gray-400">Fill in the information below to create or edit a banner.</p>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-4 sm:gap-6">
                        <!-- Image Upload -->
                        <div class="w-full lg:w-1/3">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Banner Image</label>
                                <div class="relative aspect-[16/9] rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-gray-400 transition-colors">
                                    <input
                                        type="file"
                                        name="image"
                                        accept="image/jpeg,image/png,image/webp"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        @change="handleImageUpload($event)">
                                    <div class="absolute inset-0 flex flex-col items-center justify-center" x-show="!imagePreview">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="mt-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400">Click to upload banner image</p>
                                        <p class="mt-1 text-xs text-gray-400">PNG, JPG, WEBP up to 4MB</p>
                                    </div>
                                    <img x-show="imagePreview" :src="imagePreview" class="absolute inset-0 w-full h-full object-cover rounded-xl">
                                </div>
                                <p class="text-xs text-red-500" x-text="errors.image" x-show="errors.image"></p>
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="w-full lg:w-2/3 space-y-4 sm:space-y-6">
                            <!-- Title -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Banner Title (Optional)</label>
                                <input
                                    type="text"
                                    name="title"
                                    class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-purple-500 focus:border-purple-500"
                                    placeholder="Enter banner title">
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                                <textarea
                                    name="description"
                                    rows="3"
                                    class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-purple-500 focus:border-purple-500"
                                    placeholder="Enter banner description"></textarea>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Banner Location</label>
                                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                                    <div class="flex items-center">
                                        <input
                                            type="radio"
                                            name="is_homepage"
                                            id="location_hero"
                                            value="hero"
                                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                        <label for="location_hero" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Hero Section
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input
                                            type="radio"
                                            name="is_homepage"
                                            id="location_discounted"
                                            value="discounted_section"
                                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                        <label for="location_discounted" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Discounted Section
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4 mt-6">
                        <button
                            type="button"
                            @click="$store.bannerForm.toggleForm()"
                            class="w-full sm:w-auto px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="w-full sm:w-auto px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-500 hover:from-purple-700 hover:to-blue-600 text-white rounded-lg transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Save Banner
                        </button>
                    </div>
                </form>
            </div>

            <!-- Enhanced Banners Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <tr>
                                <th class="px-3 sm:px-6 py-3 sm:py-4 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-300 font-bold">Banner</th>
                                <th class="hidden sm:table-cell px-3 sm:px-6 py-3 sm:py-4 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-300 font-bold">Description</th>
                                <th class="px-3 sm:px-6 py-3 sm:py-4 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-300 font-bold">Status</th>
                                <th class="px-3 sm:px-6 py-3 sm:py-4 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-300 font-bold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            @foreach($banners as $banner)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <td class="px-3 sm:px-6 py-3 sm:py-4">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4">
                                        <div class="flex-shrink-0 w-full sm:w-32 h-20 mb-2 sm:mb-0">
                                            @if($banner->image)
                                            <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="w-full sm:w-32 h-20 rounded-lg object-cover">
                                            @else
                                            <div class="w-full sm:w-32 h-20 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $banner->title ?? 'N/A' }}</div>
                                            <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">#{{ $banner->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden sm:table-cell px-3 sm:px-6 py-3 sm:py-4 text-gray-700 dark:text-gray-300">
                                    <div class="line-clamp-2">{{ $banner->description ?? 'N/A' }}</div>
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4">
                                    <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-medium
                                        {{ $banner->active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                        {{ $banner->active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4">
                                    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                                        <!-- Edit Button -->
                                        <a
                                            href="{{ route('banners.edit', $banner->id) }}"
                                            class="inline-flex items-center justify-center px-2 sm:px-3 py-1 sm:py-1.5 text-green-600 bg-green-100 hover:bg-green-200 rounded-full transition-colors text-xs sm:text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                            </svg>
                                            Edit
                                        </a>

                                        <!-- Toggle Status Form -->
                                        <form
                                            action="{{ route('banners.toggleStatus', $banner->id) }}"
                                            method="POST"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-2 sm:px-3 py-1 sm:py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm {{ $banner->active ? 'text-red-600 bg-red-100 hover:bg-red-200 focus:ring-red-500' : 'text-green-600 bg-green-100 hover:bg-green-200 focus:ring-green-500' }} focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $banner->active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>

                                        <!-- Delete Form -->
                                        <form
                                            action="{{ route('banners.destroy', $banner) }}"
                                            method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this banner?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-2 sm:px-3 py-1 sm:py-1.5 text-red-600 bg-red-100 hover:bg-red-200 rounded-full transition-colors text-xs sm:text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js Store -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('bannerForm', {
                isOpen: false,
                toggleForm() {
                    this.isOpen = !this.isOpen;
                }
            });
        });
    </script>

    <!-- Custom Styles -->
    <style>
        /* Fade In Animation */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fadeInDown 0.3s ease-out;
        }

        /* Custom Scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Dark mode scrollbar */
        .dark .overflow-x-auto::-webkit-scrollbar-track {
            background: #2d3748;
        }

        .dark .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #4a5568;
        }

        .dark .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #718096;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .overflow-x-auto {
                margin: 0 -1rem;
                padding: 0 1rem;
            }
        }
    </style>
</x-admin-app-layout>