tailwind.config = {
    darkMode: 'class',
}
document.addEventListener('DOMContentLoaded', () => {
    // Theme Toggle Functionality
    const themeToggle = document.getElementById('theme-toggle');
    const htmlElement = document.documentElement;

    // Initialize theme from localStorage
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        htmlElement.classList.toggle('dark', savedTheme === 'dark');
    }

    // Theme toggle event listener
    themeToggle.addEventListener('click', () => {
        htmlElement.classList.toggle('dark');

        // Save theme preference
        const isDarkMode = htmlElement.classList.contains('dark');
        localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');

        // Optional: Update toggle button icon or text
        updateThemeToggleAppearance(isDarkMode);
    });

    // Sidebar Toggle Functionality
    const sidebarToggle = document.getElementById('navbar-sidebar-toggle');
    const sidebar = document.getElementById('sidebar'); // Assuming you have a sidebar element

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('translate-x-0');
            sidebar.classList.toggle('-translate-x-full');
        });
    }

    // Responsive Dropdown Handling
    const dropdownTriggers = document.querySelectorAll('[data-dropdown-toggle]');

    dropdownTriggers.forEach(trigger => {
        trigger.addEventListener('click', (event) => {
            const dropdownId = trigger.getAttribute('data-dropdown-toggle');
            const dropdown = document.getElementById(dropdownId);

            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', (event) => {
        const dropdowns = document.querySelectorAll('[data-dropdown]');

        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(event.target) && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        });
    });

    // Optional: Accessibility Enhancements
    function updateThemeToggleAppearance(isDarkMode) {
        const toggleButton = document.getElementById('theme-toggle');
        toggleButton.setAttribute('aria-label', isDarkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode');

        // You could also update button content or icon here
        toggleButton.innerHTML = isDarkMode
            ? `<svg><!-- Light Mode Icon --></svg>`
            : `<svg><!-- Dark Mode Icon --></svg>`;
    }

    // Optional: Performance Monitoring
    const performanceMarks = {
        start: performance.mark('navbar-script-start'),
        end: performance.mark('navbar-script-end')
    };

    performance.measure(
        'Navbar Script Execution Time',
        'navbar-script-start',
        'navbar-script-end'
    );
});

// Optional: Error Handling
window.addEventListener('error', (event) => {
    console.error('Navbar Script Error:', {
        message: event.message,
        filename: event.filename,
        lineno: event.lineno,
        colno: event.colno,
        error: event.error
    });
});
