import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/js/pages/reportes.js',
                'resources/js/pages/animaciones.js',
                'resources/css/app.css',
                'resources/css/pages/reportes.css',
                'resources/css/pages/animaciones.css',
            ],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
})