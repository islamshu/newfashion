import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            ziggy: '/vendor/tightenco/ziggy/dist/vue.es.js',
        },
    },
    optimizeDeps: {
        exclude: [
            'jquery',
            'bootstrap',
            'slick-carousel',
            'swiper'
        ],
    },
});