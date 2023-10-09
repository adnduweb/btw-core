import { resolve } from 'path'
import {defineConfig} from 'vite'
import laravel, {refreshPaths} from 'laravel-vite-plugin'
 
/** @type {import('vite').UserConfig} */
export default defineConfig({
    plugins: [
        laravel({
            hotFile: 'public/front.hot',
            buildDirectory: 'front/build',
            input: [
				resolve(__dirname, 'themes/App/js/app.js')
            ],
        }),
    ],
	build: {
		chunkSizeWarningLimit: 100000000,
		rollupOptions: {
			input: resolve(__dirname, 'themes/App/js/app.js'),
			jquery: "$"
		},
	},
})