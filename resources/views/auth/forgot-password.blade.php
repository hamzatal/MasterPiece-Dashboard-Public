<x-guest-layout>
    <div class="container">
        <div class="nav-buttons">
        </div>

        <div class="login-header">
            <h1>Reset Password</h1>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <x-input-label for="email" :value="__('Email')" class="form-label" />
                <x-text-input
                    id="email"
                    class="form-input"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus />
                <x-input-error :messages="$errors->get('email')" class="text-red-500 mt-2" />
            </div>

            <div class="buttons">
                <x-primary-button class="btn btn-primary">
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>

            <a href="{{ route('login') }}" class="forgot-password">
                {{ __('Remember Password? Login') }}
            </a>
        </form>
    </div>
</x-guest-layout>
