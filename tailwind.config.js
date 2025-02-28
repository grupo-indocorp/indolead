import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans], // Fuente por defecto
                roboto: ['Roboto', 'sans-serif'], // Fuente Roboto
                poppins: ['Poppins', 'sans-serif'], // Fuente Poppins
                'open-sans': ['Open Sans', 'sans-serif'], // Fuente Open Sans
                lato: ['Lato', 'sans-serif'], // Fuente Lato
                montserrat: ['Montserrat', 'sans-serif'], // Fuente Montserrat
            },
        },
    },

    plugins: [forms, typography],
};