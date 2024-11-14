import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
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
    // server: {
    //     hmr: {
    //         host: 'grateful-star-civet.ngrok-free.app',
    //         protocol: 'wss',
    //     },
    //     origin: 'https://grateful-star-civet.ngrok-free.app',
    // }
    // server: { proxy: { '/': { target: 'https://5cd8-124-217-23-255.ngrok-free.app', changeOrigin: true, secure: false, }, }, },
});
