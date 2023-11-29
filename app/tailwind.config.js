import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/views/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'motuscolors': {
                    'back': '#363736', // default
                    'back50': '#f5f6f5',
                    'back300': '#b0b1af',
                    'back400': '#888987',
                    'back600': '#5d5e5c',

                    'text': '#ededeb', // text
                    'white': '#EDECEC', // white
                    'lightgray': '#D5D3D2', // lightgray
                    'darkgray': '#b3b3b3', // darkgray


                    'green': '#099D81', // green
                    'valid': '#099D81', // green
                    'green2': '#077563', // green hover

                    'red': '#CE6E4E', // red
                    'red2': '#9d3f31', // red hover

                    'orange': '#CEA31A', // orange
                    'orange2': '#9d7f1a', // orange hover

                    'piece': '#dc841e', // piece
                    'piece2': '#dea027', // piece
                },
                backgroundImage: {
                    'gradient1': 'linear-gradient(135deg, #363736, #888987)',

                },
            },
        },
    },

    plugins: [forms],
};
