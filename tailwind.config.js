/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: "#1773cf",
        "background-light": "#f6f7f8",
        "background-dark": "#111921",
        "foreground-light": "#111921",
        "foreground-dark": "#f6f7f8",
        "card-light": "#ffffff",
        "card-dark": "#18232f",
        "subtle-light": "#e5e7eb",
        "subtle-dark": "#253445",
        "success-light": "#10b981",
        "success-dark": "#10b981",
        "danger-light": "#ef4444",
        "danger-dark": "#ef4444",
      },
      fontFamily: {
        display: ["Work Sans", "sans-serif"],
      },
      borderRadius: {
        DEFAULT: "0.5rem",
        lg: "0.75rem",
        xl: "1rem",
        full: "9999px",
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
