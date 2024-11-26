<x-guest-layout>
<div class="nav-buttons">
        <a href="/home" class="nav-btn">Home</a>
    </div>
    <button id="theme-toggle" class="theme-toggle">
        🌞
    </button>

    <div class="container">
        <div class="login-header">
            <h1>Welcome Back</h1>
        </div>

        <form method="POST" action="{{ route('login') }}" onsubmit="return validateForm()">
            @csrf

            <div class="form-group">
                <x-input-label for="email" class="form-label">Email</x-input-label>
                <x-text-input
                    id="email"
                    class="form-input"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="form-group">
                <x-input-label for="password" class="form-label">Password</x-input-label>
                <x-text-input
                    id="password"
                    class="form-input"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="remember-me">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember">
                <label for="remember_me">Remember me</label>
            </div>

            <div class="buttons">
                <x-primary-button class="btn btn-primary">
                    Log in
                </x-primary-button>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-secondary">
                        Register
                    </a>
                @endif
            </div>

            @if (Route::has('password.request'))
            <a class="forgot-password" href="{{ route('password.request') }}">
                Forgot your password?
            </a>
            @endif
        </form>
    </div>

    @push('styles')
    <!-- Link the login.css file -->
    <link rel="stylesheet" href="{{ asset('resources/css/login.css') }}">
    @endpush

    @push('scripts')
    <!-- Link the login.js file -->
    <script src="{{ asset('resources/js/login.js') }}" defer></script>
    @endpush
</x-guest-layout>
