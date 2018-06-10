var tailwindcss = require('tailwindcss');

module.exports = {
    plugins: [
        require('precss'),
        require('autoprefixer'),
        tailwindcss('tailwind.js')
    ]
};