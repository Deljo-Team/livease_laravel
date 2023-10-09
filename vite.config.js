import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import {glob} from 'glob';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                ...glob.sync('resources/js/admin/*.js'),
            ],
            refresh: true,
        }),
    ],
});
