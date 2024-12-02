<x-app-layout>
    <x-slot name="header">

        <div class="flex justify-between items-center">
            <div>

                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 tracking-tight">
                    {{ __('Reviews Management') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Manage and moderate customer reviews') }}
                </p>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Search Input -->
                <div class="relative">
                    <input type="text"
                        id="searchReviews"
                        placeholder="{{ __('Search reviews...') }}"
                        class="w-64 pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100">
                    <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <!-- Filter Dropdown -->
                <select class="form-select rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100">
                    <option value="">{{ __('All Statuses') }}</option>
                    <option value="pending">{{ __('Pending') }}</option>
                    <option value="approved">{{ __('Approved') }}</option>
                    <option value="disapproved">{{ __('Disapproved') }}</option>
                </select>

                <!-- Add Review Button -->
                <button
                    @click="openReviewModal"
                    class="flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __('Add Review') }}
                </button>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            @php
            $stats = [
            [
            'title' => 'Total Reviews',
            'value' => $reviews->count(),
            'icon' => '
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="rgb(0, 122, 255)">
  <path d="M192 0c-41.8 0-77.4 26.7-90.5 64L64 64C28.7 64 0 92.7 0 128L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64l-37.5 0C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM72 272a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zm104-16l128 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-128 0c-8.8 0-16-7.2-16-16s7.2-16 16-16zM72 368a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zm88 0c0-8.8 7.2-16 16-16l128 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-128 0c-8.8 0-16-7.2-16-16z"/>
</svg>
            ', 'color' => 'text-blue-600'
            ],


            [
            'title' => 'Pending Reviews',
            'value' => $reviews->where('status', 'pending')->count(),
            'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />',
            'color' => 'text-yellow-500'
            ],
            [
            'title' => 'Approved Reviews',
            'value' => $reviews->where('status', 'approved')->count(),
            'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
            'color' => 'text-green-500'
            ],
            [
            'title' => 'Disapproved Reviews',
            'value' => $reviews->where('status', 'disapproved')->count(),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-500 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>',
            'color' => 'text-yellow-500'
            ],

            ];
            @endphp

            @foreach($stats as $stat)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $stat['title'] }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $stat['value'] }}</p>
                    </div>
                    <div class="p-3 rounded-full {{ str_replace('text-', 'bg-', $stat['color']) }} bg-opacity-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ $stat['color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            {!! $stat['icon'] !!}
                        </svg>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden">
            <div class="p-6">
                @if ($reviews->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full border-separate border-spacing-0 rounded-xl overflow-hidden">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                @php
                                $headers = [
                                'Name' => 'w-1/6',
                                'Email' => 'w-1/6',
                                'Rating' => 'w-1/12',
                                'Comment' => 'w-1/3',
                                'Status' => 'w-1/12',
                                'Date' => 'w-1/8',
                                'Actions' => 'w-1/6',
                                ];
                                @endphp
                                @foreach($headers as $header => $width)
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase {{ $width }}">
                                    {{ $header }}
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($reviews as $review)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-3 flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                                        <span class="text-indigo-600 dark:text-indigo-300 font-medium">
                                            {{ strtoupper(substr($review->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <span class="ml-3 font-medium text-gray-900 dark:text-gray-100">{{ $review->name }}</span>
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $review->email }}</td>
                                <td class="px-4 py-3 flex">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        @endfor
                                </td>
                                <td class="px-4 py-3">
                                    <div class="group relative">
                                        <p class="text-gray-600 dark:text-gray-300 line-clamp-2">{{ Str::limit($review->comment, 50) }}</p>
                                        @if (strlen($review->comment) > 50)
                                        <div class="hidden group-hover:block absolute z-10 w-64 p-4 mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                                            <p class="text-gray-600 dark:text-gray-300">{{ $review->comment }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-4 py-3">
                                    @php
                                    $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                    'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                    'disapproved' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                    ];
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[strtolower($review->status)] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                        {{ ucfirst($review->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                    {{ $review->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-4 py-3 flex items-center space-x-3">
                                    <form action="{{ route('reviews.updateStatus', $review) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="px-3 py-1.5 text-xs text-white bg-green-500 rounded-full hover:bg-green-600">Approve</button>
                                    </form>
                                    <form action="{{ route('reviews.updateStatus', $review) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="disapproved">
                                        <button type="submit" class="px-3 py-1.5 text-xs text-white bg-red-500 rounded-full hover:bg-red-600">Disapprove</button>
                                    </form>
                                    <form action="{{ route('reviews.toggleActive', $review) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 text-xs {{ $review->is_active ? 'bg-red-100 text-red-600 hover:bg-red-200' : 'bg-green-100 text-green-600 hover:bg-green-200' }} rounded-full">
                                            {{ $review->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-12">
                    <x-heroicon-o-document-plus class="w-16 h-16 mx-auto text-indigo-500" />
                    <p class="text-2xl font-semibold text-gray-600 dark:text-gray-300">No reviews available</p>
                </div>
                @endif
            </div>
        </div>
        @if (session('success'))
        <div x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('success') }}
        </div>
        @endif
        <!-- Review Modal -->
        <div
            x-data="reviewModal()"
            x-show="isOpen"
            x-cloak
            class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div
                    x-show="isOpen"
                    x-transition.opacity
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div
                    x-show="isOpen"
                    x-transition
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form @submit.prevent="submitReview" class="p-6 space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Name') }}
                            </label>
                            <input
                                type="text"
                                id="name"
                                x-model="review.name"
                                x-on:blur="validateName"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-500 focus:ring-opacity-50 transition-colors">
                            <p x-show="errors.name" x-text="errors.name" class="mt-1 text-xs text-red-500"></p>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Email') }}
                            </label>
                            <input
                                type="email"
                                id="email"
                                x-model="review.email"
                                x-on:blur="validateEmail"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-500 focus:ring-opacity-50 transition-colors">
                            <p x-show="errors.email" x-text="errors.email" class="mt-1 text-xs text-red-500"></p>
                        </div>

                        <div>
                            <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Comment') }}
                            </label>
                            <textarea
                                id="comment"
                                x-model="review.comment"
                                x-on:blur="validateComment"
                                rows="4"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-500 focus:ring-opacity-50 transition-colors"></textarea>
                            <p x-show="errors.comment" x-text="errors.comment" class="mt-1 text-xs text-red-500"></p>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button
                                type="button"
                                @click="closeReviewModal"
                                class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                {{ __('Cancel') }}
                            </button>
                            <button
                                type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                                {{ __('Submit Review') }}
                            </button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="mt-4">
                {{ $reviews->links() }}
            </div>
        @push('scripts')
        <script>
            function reviewModal() {
                return {
                    isOpen: false,
                    review: {
                        name: '',
                        email: '',
                        comment: ''
                    },
                    errors: {
                        name: '',
                        email: '',
                        comment: ''
                    },
                    openReviewModal() {
                        this.isOpen = true;
                    },
                    closeReviewModal() {
                        this.isOpen = false;
                        this.resetForm();
                    },
                    resetForm() {
                        this.review = {
                            name: '',
                            email: '',
                            comment: ''
                        };
                        this.errors = {
                            name: '',
                            email: '',
                            comment: ''
                        };
                    },

                    validateName() {
                        const name = this.review.name.trim();
                        if (!name) {
                            this.errors.name = 'Name is required';
                            return false;
                        }
                        if (name.length < 2) {
                            this.errors.name = 'Name must be at least 2 characters';
                            return false;
                        }
                        this.errors.name = '';
                        return true;
                    },
                    validateEmail() {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!this.review.email.trim()) {
                            this.errors.email = 'Email is required';
                            return false;
                        }
                        if (!emailRegex.test(this.review.email)) {
                            this.errors.email = 'Invalid email format';
                            return false;
                        }
                        this.errors.email = '';
                        return true;
                    },
                    validateComment() {
                        const comment = this.review.comment.trim();
                        if (!comment) {
                            this.errors.comment = 'Comment is required';
                            return false;
                        }
                        if (comment.length < 10) {
                            this.errors.comment = 'Comment must be at least 10 characters';
                            return false;
                        }
                        this.errors.comment = '';
                        return true;
                    },

                    submitReview() {
                        // Validate all fields
                        const isNameValid = this.validateName();
                        const isEmailValid = this.validateEmail();
                        const isCommentValid = this.validateComment();

                        // Only submit if all validations pass
                        if (isNameValid && isEmailValid && isCommentValid) {
                            axios.post('{{ route("reviews.store") }}', this.review)
                                .then(response => {
                                    this.closeReviewModal();
                                    // Optional: Add a toast or notification for successful submission
                                })
                                .catch(error => {
                                    // Handle server-side validation errors
                                    const serverErrors = error.response.data.errors;
                                    if (serverErrors) {
                                        this.errors.name = serverErrors.name?.[0] || '';
                                        this.errors.email = serverErrors.email?.[0] || '';
                                        this.errors.comment = serverErrors.comment?.[0] || '';
                                    }
                                });
                        }
                    }
                }
            }
        </script>
        @endpush
</x-app-layout>
