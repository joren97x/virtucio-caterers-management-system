import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    //  server: {
    //     host: '0.0.0.0', // This makes the Vite dev server accessible on all network interfaces
    //     port: 5173, // The port Vite runs on
    //     hmr: {
    //     // sa wifi ip address
    //       host: '192.168.1.13' // Use your laptop’s local IP here
    //     // piso wifi nga ip address
    //     //   host: '10.0.20.1' // Use your laptop’s local IP here
    //     }
    // }, 
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
