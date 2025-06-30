import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vuePlugin from '@vitejs/plugin-vue';

import path from 'path'; // 👈 ضروري لإعداد alias

export default defineConfig({
    plugins: [
        vuePlugin(),
        tailwindcss(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],

    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'), // 👈 alias '@' يشير إلى resources/js
            '#': path.resolve(__dirname, 'resources/front'), // ✅ يجب أن تكون صحيحة هكذا
        },
    },
});