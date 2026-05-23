import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            colors: {
                primary: "#242D2D",
                secondary: "#7EC9CE",
                tertiary: "#D1F0F3",
                whitest: "#E2EFF0",
                danger: "#E63946",
                success: "#01b920",
                warning: "#F4A261",
                massage: "#264653",
            },
            fontFamily: {
                sans: ["Plus Jakarta Sans", ...defaultTheme.fontFamily.sans],
                display: ["Kaisei Tokumin", "serif"],
            },
        },
    },

    plugins: [forms],
};
