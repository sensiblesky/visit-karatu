import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                forest: {
                    50:  '#f0f7f4',
                    100: '#daeee6',
                    200: '#b5ddcd',
                    300: '#84c3ac',
                    400: '#52a388',
                    500: '#318870',
                    600: '#236d59',
                    700: '#1b5545',
                    800: '#174538',
                    900: '#14392f',
                    950: '#0a201a',
                },
            },
        },
    },

    plugins: [forms],
};
