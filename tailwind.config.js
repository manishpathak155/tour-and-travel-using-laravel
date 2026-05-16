import defaultTheme from 'tailwindcss/defaultTheme'

export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/Filament/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                navy: { DEFAULT: '#0D1B4B', light: '#1a2d7a', dark: '#080f2b', 50: '#e8ebf4' },
                orange: { DEFAULT: '#F47920', light: '#f7944d', dark: '#c85e10', 50: '#fef3e8' },
            },
            fontFamily: {
                heading: ['Montserrat', ...defaultTheme.fontFamily.sans],
                body: ['Inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
        require('@tailwindcss/forms'),
    ],
}
