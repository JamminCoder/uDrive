/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['app/Views/**/*.{html,php,js}', 'public/**/*.{html,php,js}'],
  theme: {
    extend: {
      height: {
        '100%': 'height:100%'
      }
    },
  },
  plugins: [],
}

