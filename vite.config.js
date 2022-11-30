import { defineConfig } from "vite";
import symfonyPlugin from "vite-plugin-symfony";
import vue from '@vitejs/plugin-vue'
import { resolve, dirname } from 'node:path'
import { fileURLToPath } from 'url'
import VueI18nPlugin from '@intlify/unplugin-vue-i18n/vite'

export default defineConfig({
    plugins: [
        vue(),
        symfonyPlugin(),
        VueI18nPlugin({
            include: resolve(dirname(fileURLToPath(import.meta.url)), './assets/locales/**'),
        }),
    ],
    resolve: {
        alias: {
            '@': resolve(__dirname, './assets'),
        },
    },
    root: ".",
    base: "/build/",
    publicDir: false,
    build: {
        reportCompressedSize: true,
        manifest: true,
        emptyOutDir: true,
        assetsDir: "",
        outDir: "./public/build",
        rollupOptions: {
            input: {
                app: "./assets/app.ts"
            },
        },
    },
});
