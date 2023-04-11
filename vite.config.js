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
			outDir: "./public/",
			assetsDir: env.VITE_BUILD_DIR,
			manifest: true,
			rollupOptions: {
				// input: {
				// 	util: `./${env.VITE_RESOURCES_DIR}/js/util.js`,
				// 	app: `./${env.VITE_RESOURCES_DIR}/${env.VITE_ENTRY_FILE}`,
				// }
				input: `./${env.VITE_RESOURCES_DIR}/${env.VITE_ENTRY_FILE}`
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
			},
		},
	};
});
