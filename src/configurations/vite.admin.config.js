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
                publicDirectory: 'public/admin',
                hotFile: 'public/admin/hot',
                input: [
                    'themes/admin/js/app.js',
                    'themes/admin/css/app.css',
                    'themes/admin/css/highlight.min.css',
                    'themes/admin/css/easymde.min.css',
                    'themes/admin/css/fancybox.css',
                    'themes/admin/css/flatpickr.min.css',
                    'themes/admin/css/font-awesome.min.css',
                    'themes/admin/css/fullcalendar.min.css',
                    'themes/admin/css/highlight.min.css',
                    'themes/admin/css/markdown-editor.css',
                    'themes/admin/css/nice-select.css',
                    'themes/admin/css/nice-select2.css',
                    'themes/admin/css/nouislider.min.css',
                    'themes/admin/css/quill.snow.css',
                    'themes/admin/css/swiper-bundle.min.css',
                    'themes/admin/css/tippy.css',
                ],
                refresh: true,
            }),
        ]
    }
})