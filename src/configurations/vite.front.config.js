import { resolve } from 'path'
import {defineConfig} from 'vite'
import codeigniter from "codeigniter-vite-plugin";

/** @type {import('vite').UserConfig} */
export default defineConfig(() => {
    return {
        server: {
            host: 'localhost',
        },
        plugins: [
            codeigniter({
                publicDirectory: 'public/front',
                hotFile: 'public/front/hot',
                input: [
                    'themes/app/js/app.js',
                    'themes/app/css/app.css',
                ],
                refresh: true,
            }),
        ]
    }
})