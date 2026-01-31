import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Segoe UI', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#E6F1FF',
                    100: '#CCE4FF',
                    200: '#99C9FF',
                    300: '#66ADFF',
                    400: '#3392FF',
                    500: '#0064D2', // Main brand color
                    600: '#004BA8',
                    700: '#003A85',
                    800: '#002A61',
                    900: '#001A3D',
                },
                secondary: {
                    50: '#FFF0EB',
                    100: '#FFE1D6',
                    200: '#FFC3AD',
                    300: '#FFA585',
                    400: '#FF875C',
                    500: '#FF6B35', // Orange accent
                    600: '#E6521C',
                    700: '#B33E15',
                    800: '#802B0F',
                    900: '#4D1909',
                },
                success: {
                    500: '#06C270',
                    600: '#059857',
                },
                warning: {
                    500: '#FFB84D',
                    600: '#FF9500',
                },
                danger: {
                    500: '#E63946',
                    600: '#C5303C',
                },
                background: '#F7F9FC',
                surface: '#FFFFFF',
            },
            boxShadow: {
                'soft': '0 2px 8px rgba(0, 0, 0, 0.08)',
                'card': '0 4px 12px rgba(0, 0, 0, 0.08)',
                'hover': '0 8px 24px rgba(0, 0, 0, 0.12)',
                'strong': '0 12px 32px rgba(0, 0, 0, 0.15)',
            },
            borderRadius: {
                'card': '12px',
                'button': '8px',
            },
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
            },
        },
    },
    plugins: [forms],
};
