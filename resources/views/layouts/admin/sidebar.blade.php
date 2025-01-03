<aside id="sidebar" class="fixed left-0 top-0 h-full w-64 bg-white text-gray-900 dark:bg-[#1a1a2e] dark:text-white transform -translate-x-full transition-transform duration-300 shadow-2xl z-50 border-r border-gray-100 dark:border-gray-800">
    <!-- Logo Section (unchanged) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <div class="flex items-center justify-between px-9 py-4 border-b border-gray-200 dark:border-gray-700">
        <a href="{{ route('dashboard') }}"
            class="flex items-center space-x-1 text-2xl font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 transition-colors duration-300 group">
            <div class="flex items-center">
                <i class="fas fa-code text-3xl mr-3
                      group-hover:animate-spin
                      group-hover:text-indigo-800
                      transition-all duration-500
                      dark:group-hover:text-indigo-300"></i>
                <h1 class="text-2xl font-bold
                       group-hover:tracking-wider
                       transition-all duration-300">DevStore</h1>
            </div>
        </a>
        <!-- Close Button for Mobile (unchanged) -->
        <button id="closeSidebar" class="block lg:hidden text-gray-600 dark:text-gray-300 hover:text-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    <!-- Navigation Links -->
    <nav class="px-4 py-7 space-y-5">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
            class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-300 ease-in-out {{ request()->routeIs('dashboard') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 relative' : '' }}"
            {{ request()->routeIs('dashboard') ? 'aria-current="page"' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
            @if(request()->routeIs('dashboard'))
            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 w-2 h-2 bg-indigo-600 dark:bg-indigo-400 rounded-full"></span>
            @endif
        </a>
        <!-- Users -->
        <a href="{{ route('users.index') }}"
            class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-300 ease-in-out {{ request()->routeIs('users.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 relative' : '' }}"
            {{ request()->routeIs('users.*') ? 'aria-current="page"' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.768-.231-1.48-.634-2.026M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.768.231-1.48.634-2.026M14 10a4 4 0 11-8 0 4 4 0 018 0zm-4-7a7 7 0 00-7 7 7 7 0 007 7 7 7 0 007-7 7 7 0 00-7-7z" />
            </svg>
            Users
            @if(request()->routeIs('users.*'))
            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 w-2 h-2 bg-indigo-600 dark:bg-indigo-400 rounded-full"></span>
            @endif
        </a>

        <!-- Orders -->
        <a href="{{ route('orders.index') }}"
            class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-300 ease-in-out {{ request()->routeIs('orders.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 relative' : '' }}"
            {{ request()->routeIs('orders.*') ? 'aria-current="page"' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-2-2m0 0l-2 2m2-2v10" />
            </svg>
            Orders
            @if(request()->routeIs('orders.*'))
            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 w-2 h-2 bg-indigo-600 dark:bg-indigo-400 rounded-full"></span>
            @endif
        </a>

        <!-- Categories -->
        <a href="{{ route('categories.index') }}"
            class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-300 ease-in-out {{ request()->routeIs('categories.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 relative' : '' }}"
            {{ request()->routeIs('categories.*') ? 'aria-current="page"' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            Categories
            @if(request()->routeIs('categories.*'))
            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 w-2 h-2 bg-indigo-600 dark:bg-indigo-400 rounded-full"></span>
            @endif
        </a>

        <!-- Products -->
        <a href="{{ route('products.index') }}"
            class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-300 ease-in-out {{ request()->routeIs('products.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 relative' : '' }}"
            {{ request()->routeIs('products.*') ? 'aria-current="page"' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2h14zM7 11V7a5 5 0 0110 0v4" />
            </svg>
            Products
            @if(request()->routeIs('products.*'))
            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 w-2 h-2 bg-indigo-600 dark:bg-indigo-400 rounded-full"></span>
            @endif
        </a>

        <!-- Coupons -->
        <a href="{{ route('coupons.index') }}"
            class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-300 ease-in-out {{ request()->routeIs('coupons.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 relative' : '' }}"
            {{ request()->routeIs('coupons.*') ? 'aria-current="page"' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
            </svg>
            Coupons
            @if(request()->routeIs('coupons.*'))
            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 w-2 h-2 bg-indigo-600 dark:bg-indigo-400 rounded-full"></span>
            @endif
        </a><!-- Discounts (continued) -->
        <a href="{{ route('discounts.index') }}"
            class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-300 ease-in-out {{ request()->routeIs('discounts.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 relative' : '' }}"
            {{ request()->routeIs('discounts.*') ? 'aria-current="page"' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
            </svg>
            Discounts
            @if(request()->routeIs('discounts.*'))
            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 w-2 h-2 bg-indigo-600 dark:bg-indigo-400 rounded-full"></span>
            @endif
        </a>

        <!-- Reviews -->
        <!-- <a href="{{ route('reviews.index') }}"
            class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-300 ease-in-out {{ request()->routeIs('reviews.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 relative' : '' }}"
            {{ request()->routeIs('reviews.*') ? 'aria-current="page"' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118L2.098 9.401c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
            </svg>
            Reviews
            @if(request()->routeIs('reviews.*'))
            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 w-2 h-2 bg-indigo-600 dark:bg-indigo-400 rounded-full"></span>
            @endif
        </a> -->

        <!-- Contacts -->
        <a href="{{ route('contacts.index') }}"
            class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-300 ease-in-out {{ request()->routeIs('contacts.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 relative' : '' }}"
            {{ request()->routeIs('contacts.*') ? 'aria-current="page"' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            Contacts
            @if(request()->routeIs('contacts.*'))
            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 w-2 h-2 bg-indigo-600 dark:bg-indigo-400 rounded-full"></span>
            @endif
        </a>
        <!-- banners -->
        <a href="{{ route('banners.index') }}"
            class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-300 ease-in-out {{ request()->routeIs('banners.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 relative' : '' }}"
            {{ request()->routeIs('banners.*') ? 'aria-current="page"' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 4H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 9h10M7 12h10M7 15h6" />
                <circle cx="18" cy="15" r="2" stroke-width="2" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 16.5L22 19" />
            </svg>
            Banners
            @if(request()->routeIs('banners.*'))
            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 w-2 h-2 bg-indigo-600 dark:bg-indigo-400 rounded-full"></span>
            @endif
        </a>
    </nav>
</aside>
