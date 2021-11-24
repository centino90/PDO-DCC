const colors = require('tailwindcss/colors')

module.exports = {
  purge: {
    enabled: true,
    content: [
      './app/*.php',
      './app/**/*.php',
      './src/*.html',
      './src/**/*.html',
    ]
  },
  darkMode: false, // or 'media' or 'class'
  theme: {
    colors: {
      blue: colors.sky,
      white: colors.white,
      gray: colors.gray,
      black: colors.black,
      transparent: colors.transparent,

      // Custom
      primary: colors.fuchsia,
      secondary: colors.gray,
      success: colors.green,
      danger: colors.red,
    },
    // borderColor: theme => theme('colors')
    // fill: theme => theme('colors')
  },
  variants: {
    extend: {
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
