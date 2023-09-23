import { resolve } from 'path'
import { defineConfig, loadEnv } from 'vite'
import liveReload from 'vite-plugin-live-reload'

export default defineConfig(({ mode }) => {

  return {
	plugins: [
		liveReload([
			__dirname + '/**/*.php', 
			__dirname + '/app/Modules/**/*.php', 
			__dirname + '/vendor/adnduweb/btw-core/src/**/*.php'])
	],
    css: { devSourcemap: true },
    server: {
      host: '0.0.0.0'
    },
    build: {
	chunkSizeWarningLimit: 100000000,
      outDir: resolve(__dirname, 'public/admin'),
      emptyOutDir: false,
      rollupOptions: {
        input: resolve(__dirname, 'themes/Admin/js/app.js')
      },
      cssCodeSplit: true,
      manifest: true
    }
  }
})

// import { resolve } from 'path'
// import { defineConfig, loadEnv } from "vite";
// import liveReload from 'vite-plugin-live-reload'
// import path from "path";

// export default defineConfig(() => {
// 	const env = loadEnv(null, process.cwd());

// 	return {
// 		plugins: [
// 			liveReload([
// 				__dirname + '/**/*.php', 
// 				__dirname + '/app/Modules/**/*.php', 
// 				__dirname + '/vendor/adnduweb/btw-core/src/**/*.php'])
// 		],
// 		css: {
//             postcss: {
//                 plugins: [
//                     require("tailwindcss")({
//                         config: "./tailwind.admin.config.js",
//                     }),
//                     require("autoprefixer"),
//                 ],
//             },
//         },

// 		build: {
// 			chunkSizeWarningLimit: 100000000,
// 			emptyOutDir: false,
// 			outDir: "./public/admin",
// 			assetsDir: 'build',
// 			manifest: true,
// 			rollupOptions: {
// 				input: `./${env.VITE_RESOURCES_DIR}/${env.VITE_ENTRY_FILE_ADMIN}`,
// 				 jquery: "$"
// 			},
// 		},

// 		server: {
// 			origin: env.VITE_ORIGIN_ADMIN,
// 			port: env.VITE_PORT_ADMIN,
// 			strictPort: true,
// 		},

// 		resolve: {
// 			alias: {
// 				"@": path.resolve(__dirname, `./${env.VITE_RESOURCES_DIR}`),
// 				'$': 'jQuery',
// 				'$.fn': 'jQuery',
// 				// moment: path.resolve(__dirname, 'node_modules/moment'),
// 				daterangepicker: path.resolve(__dirname, 'node_modules/daterangepicker/daterangepicker.js'),
// 			},
// 		},
// 	};
// });