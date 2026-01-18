import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',        // login / register
                'resources/js/dashboard.js',  // dashboard
            ],
            refresh: true,
        }),
        vue(),
    ],
});
