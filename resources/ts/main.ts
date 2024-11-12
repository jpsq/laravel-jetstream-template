import { createApp, DefineComponent, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import * as Layouts from '@/layouts';
import '../css/app.css';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
        const page = await resolvePageComponent<DefineComponent>(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue') as any);
        if (!page.default.layout) {
            page.default.layout = Layouts.default;
        }
        return page;
    },
    setup({ el, App, props, plugin }): any {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue);
        registerPlugins(app);

        app.mount(el);
        el.removeAttribute('data-page');
    },
    progress: {
        color: 'hsl(var(--primary))',
    },
});
