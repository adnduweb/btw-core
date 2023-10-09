import { resolve } from 'path'
import {defineConfig} from 'vite'
import laravel, {refreshPaths} from 'laravel-vite-plugin'
 
/** @type {import('vite').UserConfig} */
export default defineConfig({
    plugins: [
        laravel({
            hotFile: 'public/admin.hot',
            buildDirectory: 'admin/build',
            input: [
				resolve(__dirname, 'themes/Admin/js/app.js')
            ],
        }),
    ],
	build: {
		chunkSizeWarningLimit: 100000000,
		rollupOptions: {
			input: resolve(__dirname, 'themes/Admin/js/app.js'),
			jquery: "$"
		},
	},
})