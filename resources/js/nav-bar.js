tailwind.config = {
    darkMode: 'class',
};

document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('theme-toggle');
    const htmlElement = document.documentElement;

    // Default to light mode if no preference is saved
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        htmlElement.classList.add('dark');
    } else {
        htmlElement.classList.remove('dark');
        localStorage.setItem('theme', 'light'); // Ensure light mode is saved as default
    }

    // Update theme toggle appearance on load
    updateThemeToggleAppearance(htmlElement.classList.contains('dark'));

    // Theme toggle button click event
    themeToggle.addEventListener('click', () => {
        const isDarkMode = htmlElement.classList.toggle('dark');
        localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
        updateThemeToggleAppearance(isDarkMode);
    });

    // Sidebar toggle functionality
    const sidebarToggle = document.getElementById('navbar-sidebar-toggle');
    const sidebar = document.getElementById('sidebar');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('translate-x-0');
            sidebar.classList.toggle('-translate-x-full');
        });
    }

    // Responsive dropdown functionality
    const dropdownTriggers = document.querySelectorAll('[data-dropdown-toggle]');
    dropdownTriggers.forEach(trigger => {
        trigger.addEventListener('click', (event) => {
            const dropdownId = trigger.getAttribute('data-dropdown-toggle');
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) dropdown.classList.toggle('hidden');
        });
    });

    // Close all dropdowns when clicking outside
    document.addEventListener('click', (event) => {
        dropdownTriggers.forEach(trigger => {
            const dropdownId = trigger.getAttribute('data-dropdown-toggle');
            const dropdown = dropdownId ? document.getElementById(dropdownId) : null;
            if (dropdown && !dropdown.contains(event.target) && event.target !== trigger) {
                dropdown.classList.add('hidden');
            }
        });
    });

    // Update theme toggle button appearance
    function updateThemeToggleAppearance(isDarkMode) {
        const toggleButton = document.getElementById('theme-toggle');
        toggleButton.setAttribute('aria-label', isDarkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode');

        // Example: Updating toggle button icon (replace SVG paths with your icons)
        toggleButton.innerHTML = isDarkMode
            ? `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v3m0 12v3m9-9h-3M6 12H3m15.364-6.364l-2.121 2.121M6.343 6.343l-2.121 2.121M18.364 18.364l-2.121-2.121M6.343 17.657l-2.121-2.121"></path></svg>` // Light mode icon
            : `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 118.646 3.646 7 7 0 0020.354 15.354z"></path></svg>`; // Dark mode icon
    }

    // Optional: Error handling for debugging
    window.addEventListener('error', (event) => {
        console.error('Error:', event.message, event.error);
    });

    // Performance logging (optional, useful for debugging slow UI interactions)
    performance.mark('script-loaded');
    performance.measure('Script Load Time', 'navigationStart', 'script-loaded');
});
