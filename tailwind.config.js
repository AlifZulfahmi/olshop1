/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'false',
  content: [
    "./node_modules/flowbite/**/*.js",
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  theme: {
    extend: {
        colors: {
        primary: {
        '50': '#edfcf6',
        '100': '#d4f7e8',
        '200': '#aceed6',
        '300': '#76dfbe',
        '400': '#3fc8a2',
        '500': '#1bae8a',
        '600': '#0f8c70',
        '700': '#0d7c66',
        '800': '#0c594a',
        '900': '#0b493e',
        '950': '#052924',
        }
      }
    },
  },
  plugins: [
      require('flowbite/plugin')
    ],
}