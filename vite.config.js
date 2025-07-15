import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/images/skillsync_logo.jpeg',
                'resources/images/default-profile-image.jpeg',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/scss/admin.scss',
                'resources/scss/user.scss',
                'resources/js/components/disableButtonSubmit.js',
                'resources/js/components/toggleNavBar.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '$': 'jQuery'
        },
    },
});
