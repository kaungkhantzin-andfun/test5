const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Http/Livewire/**/*.php',
    ],
    theme: {
        screens: {
            'xs': '375px',
            ...defaultTheme.screens,
        },
        extend: {
            colors: {
                logo: {
                    blue: {
                        light: '#6880bf',
                        DEFAULT: '#2564ae',
                        dark: '#0f4c88',
                    },
                    green: {
                        DEFAULT: '#269746',
                        light: '#4ab866',
                    },
                    purple: {
                        DEFAULT: '#8d58a0'
                    }
                },
            },
            boxShadow: {
                'raised': '0 0 20px 0 rgb(62 28 131 / 10%)',
            },
            typography: {
                DEFAULT: {
                    css: {
                        // for prose class from tailwind typography plugin
                        maxWidth: null,
                    }
                },
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
    ],
};
