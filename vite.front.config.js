import { resolve } from 'path'
import { defineConfig, loadEnv } from "vite";
import liveReload from 'vite-plugin-live-reload'
import path from "path";

export default defineConfig(() => {
	const env = loadEnv(null, process.cwd());

	return {
		plugins: [
			liveReload([__dirname + '/**/*.php', __dirname + '/app/Modules/**/*.php', , __dirname + '/vendor/adnduweb/btw-core/src/**/*.php'])
		],

		build: {
			chunkSizeWarningLimit: 100000000,
			emptyOutDir: false,
			outDir: "./public/front",
			assetsDir: 'build',
			manifest: true,
			rollupOptions: {
				input: `./${env.VITE_RESOURCES_DIR}/${env.VITE_ENTRY_FILE_FRONT}`,
				 jquery: "$"
			},
		},

		server: {
			origin: env.VITE_ORIGIN,
			port: env.VITE_PORT,
			strictPort: true,
		},

		resolve: {
			alias: {
				"@": path.resolve(__dirname, `./${env.VITE_RESOURCES_DIR}`),
				'$': 'jQuery',
				'$.fn': 'jQuery',
				// moment: path.resolve(__dirname, 'node_modules/moment'),
				daterangepicker: path.resolve(__dirname, 'node_modules/daterangepicker/daterangepicker.js'),
			},
		},
	};
});
