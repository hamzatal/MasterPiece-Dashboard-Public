import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/css/password-reset.css",
                "resources/css/login.css",
                "resources/js/login.js",
                "resources/css/dashboard-sidebar.css",
                "resources/js/dashboard-sidebar.js",

            ],
            refresh: true,
        }),
    ],
});
