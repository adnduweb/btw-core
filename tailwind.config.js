/** @type {import('tailwindcss').Config} */
const plugin = require("tailwindcss/plugin");
const defaultTheme = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors')
module.exports = {
	//darkMode: 'class',
	mode: 'jit',
	content: [
		"./app/Modules/**/*.php",
		"./themes/**/*.php",
		"./themes/**/**/*.php",
		"./themes/**/**/**/*.php",
		"./themes/**/*.js",
		"./app/Views/*.php",
		"./vendor/adnduweb/btw-core/src/**/*.php",
		"./vendor/adnduweb/btw-core/src/Views/*.php",
		"./vendor/adnduweb/btw-core/src/Views/**/*.php",
		"./vendor/adnduweb/btw-core/themes/**/**/*.php",
		"./vendor/adnduweb/btw-core/themes/**/**/**/*.php",
		"./node_modules/flowbite/**/*.js"
	],
	theme: {

		extend: {
			fontFamily: {
				sans: ['Inter var', ...defaultTheme.fontFamily.sans],
			},
			minHeight: {
				"screen-75": "75vh",
			},
			fontSize: {
				55: "55rem",
			},
			opacity: {
				80: ".8",
			},
			zIndex: {
				2: 2,
				3: 3,
			},
			inset: {
				"-100": "-100%",
				"-225-px": "-225px",
				"-160-px": "-160px",
				"-150-px": "-150px",
				"-94-px": "-94px",
				"-50-px": "-50px",
				"-29-px": "-29px",
				"-20-px": "-20px",
				"25-px": "25px",
				"40-px": "40px",
				"95-px": "95px",
				"145-px": "145px",
				"195-px": "195px",
				"210-px": "210px",
				"260-px": "260px",
			},
			height: {
				"95-px": "95px",
				"70-px": "70px",
				"350-px": "350px",
				"500-px": "500px",
				"600-px": "600px",
			},
			maxHeight: {
				"860-px": "860px",
			},
			maxWidth: {
				"100-px": "100px",
				"120-px": "120px",
				"150-px": "150px",
				"180-px": "180px",
				"200-px": "200px",
				"210-px": "210px",
				"580-px": "580px",
			},
			minWidth: {
				"140-px": "140px",
				48: "12rem",
			},
			backgroundSize: {
				full: "100%",
			},
		},
		animation: {
			none: 'none',
			spin: 'spin 1s linear infinite',
			ping: 'ping 1s cubic-bezier(0, 0, 0.2, 1) infinite',
			pulse: 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
			bounce: 'bounce 1s infinite',
			'slide-in-right': 'slide-in-right .3s ease-in',
			'slide-in-left': 'slide-in-left .3s ease-in',
		  },
		  aspectRatio: {
			auto: 'auto',
			square: '1 / 1',
			video: '16 / 9',
		  },
		theme: {
			colors: {
				transparent: 'transparent',
				current: 'currentColor',
				black: colors.black,
				green: colors.green,
				red: colors.red,				
				white: colors.white,
				gray: colors.gray,
				emerald: colors.emerald,
				indigo: colors.indigo,
				yellow: colors.yellow
			},
		},
	},
	variants: [
		"responsive",
		"group-hover",
		"focus-within",
		"first",
		"last",
		"odd",
		"even",
		"hover",
		"focus",
		"active",
		"visited",
		"disabled",
	],
	plugins: [

		//require("daisyui"),

		require('flowbite/plugin'),

		require('tw-elements/dist/plugin'),

		// Add Tailwind Typography.
		require('@tailwindcss/typography'),

		require('@tailwindcss/forms'),

		require('@tailwindcss/aspect-ratio'),

		plugin(function ({ addComponents, theme }) {
			const screens = theme("screens", {});
			addComponents([
				{
					".container": { width: "100%" },
				},
				{
					[`@media (min-width: ${screens.sm})`]: {
						".container": {
							"max-width": "640px",
						},
					},
				},
				{
					[`@media (min-width: ${screens.md})`]: {
						".container": {
							"max-width": "768px",
						},
					},
				},
				{
					[`@media (min-width: ${screens.lg})`]: {
						".container": {
							"max-width": "1024px",
						},
					},
				},
				{
					[`@media (min-width: ${screens.xl})`]: {
						".container": {
							"max-width": "1280px",
						},
					},
				},
				{
					[`@media (min-width: ${screens["2xl"]})`]: {
						".container": {
							"max-width": "1280px",
						},
					},
				},
			]);
		}),


	]
}
