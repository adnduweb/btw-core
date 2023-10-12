/** @type {import('tailwindcss').Config} */
const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");
module.exports = {
  darkMode: 'class',
  mode: "jit",
  content: ["./app/Modules/**/*.php",
    "./themes/**/*.php",
    "./themes/**/**/*.php",
    "./themes/**/**/**/*.php",
    "./themes/**/*.js",
    "./app/Views/*.php",
    "./vendor/adnduweb/btw-core/src/**/*.php",
    "./vendor/adnduweb/btw-core/src/Views/*.php",
    "./vendor/adnduweb/btw-core/src/Views/**/*.php",
    "./vendor/adnduweb/btw-core/themes/**/**/*.php",
    "./vendor/adnduweb/btw-core/themes/**/**/**/*.php"],
  theme: {
    container: {
      center: true,
    },
    extend: {
      colors: {
        primary: {
          DEFAULT: "#4361ee",
          light: "#eaf1ff",
          "dark-light": "rgba(67,97,238,.15)",
        },
        secondary: {
          DEFAULT: "#805dca",
          light: "#ebe4f7",
          "dark-light": "rgb(128 93 202 / 15%)",
        },
        success: {
          DEFAULT: "#00ab55",
          light: "#ddf5f0",
          "dark-light": "rgba(0,171,85,.15)",
        },
        danger: {
          DEFAULT: "#e7515a",
          light: "#fff5f5",
          "dark-light": "rgba(231,81,90,.15)",
        },
        warning: {
          DEFAULT: "#e2a03f",
          light: "#fff9ed",
          "dark-light": "rgba(226,160,63,.15)",
        },
        info: {
          DEFAULT: "#2196f3",
          light: "#e7f7ff",
          "dark-light": "rgba(33,150,243,.15)",
        },
        dark: {
          DEFAULT: "#3b3f5c",
          light: "#eaeaec",
          "dark-light": "rgba(59,63,92,.15)",
        },
        black: {
          DEFAULT: "#0e1726",
          light: "#e3e4eb",
          "dark-light": "rgba(14,23,38,.15)",
        },
        white: {
          DEFAULT: "#ffffff",
          light: "#e0e6ed",
          dark: "#888ea8",
        },
      },
      fontFamily: {
        nunito: ["Nunito", "sans-serif"],
      },
      spacing: {
        4.5: "18px",
      },
      boxShadow: {
        "3xl":
          "0 2px 2px rgb(224 230 237 / 46%), 1px 6px 7px rgb(224 230 237 / 46%)",
      },
      typography: {
        DEFAULT: {
          css: {
            h1: { fontSize: "40px" },
            h2: { fontSize: "32px" },
            h3: { fontSize: "28px" },
            h4: { fontSize: "24px" },
            h5: { fontSize: "20px" },
            h6: { fontSize: "16px" },
          },
        },
      },
      keyframes: {
        buzz: {
          "0%": { transform: "scale(.99)" },
          "25%": { transform: "scale(1.01)" },
          "50%": { transform: "scale(.99)" },
          "75%": { transform: "scale(1.01)" },
        },
      },
    },
    animation: {
      none: "none",
      spin: "spin 1s linear infinite",
      ping: "ping 1s cubic-bezier(0, 0, 0.2, 1) infinite",
      pulse: "pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite",
      bounce: "bounce 1s infinite",
      "slide-in-right": "slide-in-right .3s ease-in",
      "slide-in-left": "slide-in-left .3s ease-in",
      buzz: "buzz .2s ease-in-out",
    },
  },
  plugins: [
    require("@tailwindcss/forms")({
      strategy: "base", // only generate global styles
    }),
    require("@tailwindcss/typography"),
  ],
};