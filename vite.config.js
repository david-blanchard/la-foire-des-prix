import { defineConfig } from 'vite';
import symfonyPlugin from 'vite-plugin-symfony';
import { viteStaticCopy } from 'vite-plugin-static-copy';
import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [
    react(),
    symfonyPlugin(),
    viteStaticCopy({
      targets: [
        {
          src: 'assets/images/*',
          dest: 'images', // Cela va copier dans /dist/images
        },
        {
          src: 'node_modules/font-awesome/fonts/*',
          dest: 'fonts', // This will copy to /dist/fonts
        },
      ],
    }),
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
        main: './app/main.tsx',
        app: './assets/js/app.js',
        style: './assets/styles/app.css',
      },
      output: {
        entryFileNames: 'js/[name].js',
        chunkFileNames: 'js/[name].js',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name === 'style.css') {
            return 'css/style.css';
          }
          if (assetInfo.name === 'app.css') {
            return 'css/app.css';
          }
          return 'assets/[name].[ext]';
        },
      },
      preserveEntrySignatures: 'strict',
      manualChunks: {
        vendor: ['react', 'react-dom', 'react-router-dom', 'axios'],
        bootstrap: ['bootstrap', 'jquery'],
        'font-awesome': ['font-awesome'],
        'bootstrap-icons': ['bootstrap-icons'],
      },
    },
  },
  server: {
    port: 5173,
    strictPort: true,
    cors: true,
  },
});
