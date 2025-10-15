import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: '#FAF4F2',
                    50: '#FFFFFF',
                    100: '#FAF4F2',
                    200: '#F5E9E5',
                    300: '#E8D4CB',
                    400: '#D4A373',
                    500: '#C89363',
                    600: '#B87D4F',
                    700: '#9F6A42',
                    800: '#7F5435',
                    900: '#5F3F28',
                },
                accent: {
                    DEFAULT: '#D4A373',
                    light: '#E5B88A',
                    hover: '#C89363',
                    dark: '#B87D4F',
                },
                amber: {
                    DEFAULT: '#D97D34',
                    light: '#E59556',
                    dark: '#C06D2B',
                },
                secondary: {
                    DEFAULT: '#8B9A7D',
                    light: '#A3B094',
                    dark: '#738566',
                },
                tertiary: {
                    DEFAULT: '#6B7F99',
                    light: '#8496AD',
                    dark: '#556685',
                },
            },
            fontFamily: {
                display: ['"Cormorant Garamond"', 'Georgia', 'serif'],
                body: ['"Inter"', 'system-ui', ...defaultTheme.fontFamily.sans],
                sans: ['"Inter"', 'system-ui', ...defaultTheme.fontFamily.sans],
            },
            spacing: {
                '0': '0',
                '1': '0.5rem',
                '2': '1rem',
                '3': '1.5rem',
                '4': '2rem',
                '5': '2.5rem',
                '6': '3rem',
                '8': '4rem',
                '10': '5rem',
                '12': '6rem',
                '16': '8rem',
                '20': '10rem',
                '24': '12rem',
            },
            boxShadow: {
                'xs': '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
                'sm': '0 2px 8px rgba(0, 0, 0, 0.08)',
                'md': '0 4px 16px rgba(0, 0, 0, 0.12)',
                'lg': '0 8px 24px rgba(0, 0, 0, 0.15)',
                'xl': '0 12px 32px rgba(0, 0, 0, 0.18)',
                '2xl': '0 24px 48px rgba(0, 0, 0, 0.22)',
            },
            animation: {
                'fade-up': 'fadeUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards',
                'fade-in': 'fadeIn 0.4s ease-out',
            },
            keyframes: {
                fadeUp: {
                    '0%': { opacity: '0', transform: 'translateY(30px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
            },
        },
    },

    plugins: [forms],
};
