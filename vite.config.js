import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
        server: {
            host: '0.0.0.0', // Позволяет подключаться извне контейнера
            port: 5173, // HTTP-порт
            strictPort: true,
            hmr: {
                host: 'localhost',
                port: 5174,
            }
        },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
