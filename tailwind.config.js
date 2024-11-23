import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    darkMode: "class", // Enable class-based dark mode

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Optionally, extend your color palette for custom dark mode colors
                dark: {
                    background: "#1a202c", // Example dark background color
                    text: "#e2e8f0", // Example light text color for dark mode
                },
                light: {
                    background: "#ffffff", // Example light background color
                    text: "#2d3748", // Example dark text color for light mode
                },
            },
        },
    },

    plugins: [forms],
};
