tailwind.config = {
    darkMode: "class",
};

document.addEventListener("DOMContentLoaded", () => {
    const themeToggle = document.getElementById("theme-toggle");
    const htmlElement = document.documentElement;

    // Check saved theme in localStorage
    const savedTheme = localStorage.getItem("theme");

    if (savedTheme === "dark") {
        htmlElement.classList.add("dark");
    } else {
        htmlElement.classList.remove("dark");
        localStorage.setItem("theme", "light");
    }

    // Update the toggle button appearance
    updateThemeToggleAppearance(htmlElement.classList.contains("dark"));

    // Handle theme toggle click
    themeToggle.addEventListener("click", () => {
        const isDarkMode = htmlElement.classList.toggle("dark");
        localStorage.setItem("theme", isDarkMode ? "dark" : "light");
        updateThemeToggleAppearance(isDarkMode);
    });

    function updateThemeToggleAppearance(isDarkMode) {
        const toggleButton = document.getElementById("theme-toggle");
        toggleButton.setAttribute(
            "aria-label",
            isDarkMode ? "Switch to Light Mode" : "Switch to Dark Mode"
        );

        toggleButton.innerHTML = isDarkMode
            ? `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v3m0 12v3m9-9h-3M6 12H3m15.364-6.364l-2.121 2.121M6.343 6.343l-2.121 2.121M18.364 18.364l-2.121-2.121M6.343 17.657l-2.121-2.121"></path></svg>`
            : `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 118.646 3.646 7 7 0 0020.354 15.354z"></path></svg>`;
    }
});
