import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        cors: {
        // Replace with your specific domain or use true for '*'
        origin: 'https://lpse.geolandmap.co.id',
        methods: ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'],
        allowedHeaders: ['Content-Type', 'Authorization', 'X-Requested-With'],
        },
        // If you are using IPv6 [::1], sometimes forcing 127.0.0.1 helps consistency
        host: '127.0.0.1', 
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
