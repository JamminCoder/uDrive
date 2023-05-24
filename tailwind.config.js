/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['app/Views/**/*.{html,php,js}', 'public/**/*.{html,php,js}'],
  theme: {
    extend: {
      width: {
        '100%': 'width:100%'
      },
      
      height: {
        '100%': 'height:100%'
      }
    },
  },
  plugins: [],
}

