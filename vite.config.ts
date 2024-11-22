import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { fileURLToPath } from 'node:url';
import vueJsx from '@vitejs/plugin-vue-jsx';
import AutoImport from 'unplugin-auto-import/vite';
import Components from 'unplugin-vue-components/vite';
import svgLoader from 'vite-svg-loader';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/ts/main.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        vueJsx(),
        Components({
            dirs: ['./resources/ts/components', './resources/ts/core/components'],
            dts: true,
            resolvers: [
                (componentName) => {
                    if (componentName === 'VueApexCharts') return { name: 'default', from: 'vue3-apexcharts', as: 'VueApexCharts' };
                },
            ],
        }),
        AutoImport({
            imports: [
                'vue',
                '@vueuse/core',
                '@vueuse/math',
                'vue-i18n',
                'pinia',
                { '@inertiajs/vue3': ['router', 'useForm', 'usePage'] },
                // { 'vue-sonner': [['toast', 'sonnerToast']] },
            ],
            dirs: ['./resources/ts/lib', './resources/ts/core/lib', './resources/ts/core/composables'],

            vueTemplate: true,
            // ℹ️ Disabled to avoid confusion & accidental usage
            ignore: ['useCookies', 'useStorage'],
        }),
        svgLoader({
            defaultImport: 'url',
        }),
        // watch({
        //     command: 'echo "generate env types" && npx dotenv-types-generator',
        //     pattern: ['./.env'],
        // }),
    ],
    define: {
        'process.env': {
            hugo: 'hugo',
        },
    },
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./resources/ts', import.meta.url)),
            '@core': fileURLToPath(new URL('./resources/ts/core', import.meta.url)),
            '@images': fileURLToPath(new URL('./resources/assets/images', import.meta.url)),
            '@assets': fileURLToPath(new URL('./resources/assets', import.meta.url)),
        },
    },
    build: {
        chunkSizeWarningLimit: 500,
        target: 'esnext',
    },
    esbuild: {
        target: 'esnext',
    },
    optimizeDeps: {
        entries: ['./resources/ts/**/*.vue'],
        esbuildOptions: {
            target: 'esnext',
        },
    },
    server: {
        // https: true,
        hmr: { overlay: false },
        watch: {
            ignored: [`${__dirname}/vendor`, `${__dirname}/storage`, `${__dirname}/public`, `${__dirname}/**/*.php`],
        },
    },
});
