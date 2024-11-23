<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Review') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
            <form method="POST" action="{{ route('reviews.edit', $review->id) }}">
                @csrf
                @method('PUT')

                <!-- Reviewer's Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Name') }}
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $review->name) }}"
                        class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md"
                        required>
                    @error('name')
                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Reviewer's Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Email') }}
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $review->email) }}"
                        class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md"
                        required>
                    @error('email')
                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Review Rating -->
                <div class="mb-4">
                    <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Rating') }}
                    </label>
                    <select name="rating" id="rating"
                        class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md">
                        @foreach (range(1, 5) as $star)
                            <option value="{{ $star }}" {{ $review->rating == $star ? 'selected' : '' }}>
                                {{ $star }}
                            </option>
                        @endforeach
                    </select>
                    @error('rating')
                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Review Comment -->
                <div class="mb-4">
                    <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Comment') }}
                    </label>
                    <textarea name="comment" id="comment" rows="4"
                        class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md">{{ old('comment', $review->comment) }}</textarea>
                    @error('comment')
                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Review Status -->
                <div class="mb-6">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Status') }}
                    </label>
                    <select name="status" id="status"
                        class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md">
                        <option value="pending" {{ $review->status === 'pending' ? 'selected' : '' }}>
                            {{ __('Pending') }}
                        </option>
                        <option value="approved" {{ $review->status === 'approved' ? 'selected' : '' }}>
                            {{ __('Approved') }}
                        </option>
                        <option value="disapproved" {{ $review->status === 'disapproved' ? 'selected' : '' }}>
                            {{ __('Disapproved') }}
                        </option>
                    </select>
                    @error('status')
                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <a href="{{ route('reviews.index') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-md shadow-sm hover:bg-gray-200 dark:hover:bg-gray-600">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit"
                        class="ml-3 inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700">
                        {{ __('Update Review') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
