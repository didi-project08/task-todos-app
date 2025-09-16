import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import compression from 'vite-plugin-compression';

// export default defineConfig({
//     plugins: [
//         laravel({
//             input: ['resources/css/app.css', 'resources/js/app.js'],
//             refresh: true,
//         }),
//         tailwindcss(),
//         compression(),
//     ],
//     build: {
//         outDir: 'public/build',
//         minify: true,
//         sourcemap: false,
//     },
// });

export default defineConfig(({ mode }) => {
    const isProduction = mode === 'production';
    
    return {
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
            tailwindcss(),
            compression(),
        ],
        build: {
            outDir: 'public/build',
            minify: isProduction ? 'esbuild' : false,
            sourcemap: !isProduction,
        },
    };
});
