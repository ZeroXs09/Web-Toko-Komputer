/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        dark: {
          bg: '#2a2a2a',
          light: '#1a1a1a',
        }
      }
    },
  },
  plugins: [],
}
