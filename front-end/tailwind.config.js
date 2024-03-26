/** @type {import('tailwindcss').Config} */

//  this are my basic colors     background-image: linear-gradient(102.02deg, #921108, #921108 10%, #d23228 0, #d23228 90%, #002121 0, #002121); 
module.exports = {
  content: [
    "./src/**/*.{html,ts}",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#d23228', // replace with your primary color
        secondary: '#0e3639', // replace with your secondary color
        primaryhover: '#921108', // replace with your secondary color
        lighthover: '#bfc9ca', // replace with your secondary color
        secondaryhover: '#2d494e', // replace with your secondary color
      },
      height: {
        '38': '38px',
      },
    },
  },
  plugins: [],
}