<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ecommerce') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css" />
    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-duotone-solid.css" />
    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-thin.css" />
    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-solid.css" />
    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-regular.css" />
    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-light.css" />

    <!-- In your head section or before closing body tag -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.7/dist/cdn.min.js"></script>


    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets')}}/img/favicon.ico">

    <!-- ======= All CSS Plugins here ======== -->
    <link rel="stylesheet" href="{{asset('assets')}}/css/plugins/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{asset('assets')}}/css/plugins/glightbox.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700&amp;family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500&amp;display=swap" rel="stylesheet">

    <!-- Plugin css -->
    <link rel="stylesheet" href="{{asset('assets')}}/css/vendor/bootstrap.min.css">

    <!-- Custom Style CSS -->
    <link rel="stylesheet" href="{{asset('assets')}}/css/style.css">

</head>

<body class="font-sans antialiased">
    <div class="flex">
        <!-- Main Content -->
        <div id="main-content" class="flex-1 min-h-screen bg-gray-100 dark:bg-gray-900 transition-all duration-300">
            <!-- Navigation -->
            @include('layouts.ecommerce.navigation')
            <!-- Page Content -->
            <main>
                <!-- Loading -->
                 @include('layouts.ecommerce.loading')
                {{ $slot }}
            </main>
            <!-- Footer -->
            @include('layouts.ecommerce.footer')
        </div>
    </div>

    <!-- QuickView Wrapper -->
     @include('layouts.ecommerce.quick-wrapper')

    <!-- Back to top button -->
     @include('layouts.ecommerce.back-to-top')

    <!-- All Script JS Plugins here  -->
    <script src="{{asset('assets')}}/js/vendor/popper.js" defer="defer"></script>
    <script src="{{asset('assets')}}/js/vendor/bootstrap.min.js" defer="defer"></script>
    <script src="{{asset('assets')}}/js/plugins/swiper-bundle.min.js"></script>
    <script src="{{asset('assets')}}/js/plugins/glightbox.min.js"></script>

    <!-- Customscript js -->
    <script src="{{asset('assets')}}/js/script.js"></script>
</body>

</html>