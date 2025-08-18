import {defineConfig} from 'vite'
import symfonyPlugin from 'vite-plugin-symfony'
import {viteStaticCopy} from 'vite-plugin-static-copy';

export default defineConfig({
    plugins: [
        symfonyPlugin(),
        viteStaticCopy({
            targets: [
                {
                    src: 'assets/images/*',
                    dest: 'images'  // Cela va copier dans /dist/images
                },
            ]
        })
    ],
    root: '.',
    base: '/build/',
    build: {
        manifest: true,
        emptyOutDir: true,
        assetsDir: '',
        outDir: 'public/build',
        rollupOptions: {
            input: {
                app: './assets/js/app.js',
                style: './assets/styles/app.css',
            }
        }
    },
    server: {
        port: 5173,
        strictPort: true,
        cors: true
    }
})
