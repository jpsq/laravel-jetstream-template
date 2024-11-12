import { PageProps as InertiaPageProps } from '@inertiajs/core';
import { route as ziggyRoute } from 'ziggy-js';
import { AppPageProps } from '@/types';

declare global {
    /* eslint-disable no-var */
    var route: typeof ziggyRoute;
}
import { ComponentCustomProperties as CCp } from 'vue';
declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
        route: typeof ziggyRoute;
    }
}

declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps, AppPageProps {}
}
