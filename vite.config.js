import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/components/select-user.css',
                'resources/js/app.js',
                'resources/js/components/select-user.js',
            ],
            refresh: true,
        }),
    ],
});
