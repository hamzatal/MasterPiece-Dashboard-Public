document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("main-content");
    const sidebarToggleButtons = document.querySelectorAll("#navbar-sidebar-toggle");
    const themeToggle = document.getElementById("theme-toggle");
    const html = document.documentElement;

    // Sidebar Toggle Logic
    sidebarToggleButtons.forEach((button) => {
        button.addEventListener("click", () => {
            sidebar.classList.toggle("-translate-x-full");

            // Adjust main content margin based on sidebar visibility
            if (sidebar.classList.contains("-translate-x-full")) {
                mainContent.style.marginLeft = "0";
            } else {
                mainContent.style.marginLeft = "16rem"; // Adjust based on your sidebar width
            }
            
        });
    });

    // Set initial sidebar state based on screen size
    const setSidebarState = () => {
        if (window.innerWidth >= 768) {
            sidebar.classList.remove("-translate-x-full");
            mainContent.style.marginLeft = "16rem";
        } else {
            sidebar.classList.add("-translate-x-full");
            mainContent.style.marginLeft = "0";
        }
    };

    setSidebarState();

    // Adjust sidebar on window resize
    window.addEventListener("resize", setSidebarState);

    // Theme Toggle Logic
    // Check localStorage for theme preference
    if (localStorage.getItem("theme") === "dark") {
        html.classList.add("dark");
    }

    // Toggle theme and save preference to localStorage
    themeToggle.addEventListener("click", () => {
        if (html.classList.contains("dark")) {
            html.classList.remove("dark");
            localStorage.setItem("theme", "light");
        } else {
            html.classList.add("dark");
            localStorage.setItem("theme", "dark");
        }
    });
});
