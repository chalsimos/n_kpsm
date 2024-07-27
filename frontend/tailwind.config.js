module.exports = {
	content: [
		"./index.html",
		"./src/**/*.{vue,js,ts,jsx,tsx}",
		"./node_modules/flowbite/**/*.js",
		"./node_modules/tw-elements/js/**/*.js"
	],
	theme: {
		extend: {
			fontFamily: {
				sans: ['Avenir', 'Helvetica', 'Arial', 'sans-serif'],
			},
		},
	},
	plugins: [require("tw-elements/plugin.cjs"),
		require('flowbite/plugin')],
}
