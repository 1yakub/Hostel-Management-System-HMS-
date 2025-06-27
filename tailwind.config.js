const colors = require("tailwindcss/colors");
const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],
    theme: {
        extend: {
            colors: {
                luxury: {
                    50: "#F9F6F3",
                    100: "#F3EDE7",
                    200: "#E7DBCF",
                    300: "#DBC9B7",
                    400: "#CFB79F",
                    500: "#C3A587",
                    600: "#B7936F",
                    700: "#8C6D4F",
                    800: "#61472F",
                    900: "#362210",
                },
                gold: {
                    50: "#FDFAF3",
                    100: "#FBF5E7",
                    200: "#F7EBCF",
                    300: "#F3E1B7",
                    400: "#EFD79F",
                    500: "#EBCD87",
                    600: "#E7C36F",
                    700: "#BC9441",
                    800: "#8C6A23",
                    900: "#5C4005",
                },
                accent: {
                    50: "#F5F3FF",
                    100: "#EDE9FE",
                    200: "#DDD6FE",
                    300: "#C4B5FD",
                    400: "#A78BFA",
                    500: "#8B5CF6",
                    600: "#7C3AED",
                    700: "#6D28D9",
                    800: "#5B21B6",
                    900: "#4C1D95",
                    950: "#2E1065",
                },
            },
            fontFamily: {
                sans: ["Montserrat", "sans-serif"],
                serif: ["Playfair Display", "serif"],
            },
            boxShadow: {
                luxury: "0 4px 20px rgba(140, 109, 79, 0.1)",
                "luxury-lg": "0 10px 30px rgba(140, 109, 79, 0.2)",
            },
        },
    },
    plugins: [require("@tailwindcss/forms")],
};
