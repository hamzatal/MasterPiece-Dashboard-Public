<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App Name -->
    <title>{{ config('app.name', 'CoderZ') }}</title>

    <!-- icon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('braces.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/js/dashboard-sidebar.js', 'resources/css/app.css', 'resources/css/pace.min.css','resources/css/bootstrap.min.css','resources/css/icons.css',' resources/css/appp.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased">
    <div class="flex">
        <!-- Sidebar -->
        @include('layouts.admin.sidebar')

        <!-- Main Content -->
        <div id="main-content" class="flex-1 min-h-screen bg-gray-100 dark:bg-gray-900 transition-all duration-300">
            <!-- Navigation -->
            @include('layouts.admin.navigation')

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

        </div>
    </div>


</body>

</html>
