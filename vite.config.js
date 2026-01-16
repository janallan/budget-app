import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { viteStaticCopy } from 'vite-plugin-static-copy'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        viteStaticCopy({
            targets: [
                {
                    src: 'resources/images',
                    dest: ''
                },
            ]
        }),
    ],
    theme: {
        extend: {
            backgroundColor: {
                'modal-overlay': 'rgba(0, 0, 0, 1)'
            }
        }
    }
});
