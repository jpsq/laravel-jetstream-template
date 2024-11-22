import Icon from '@/components/Icon.vue';
import { ExternalToast,toast as sonnerToast } from 'vue-sonner';


export function sonnerInfo(message: string | Component, data?: ExternalToast) {
    sonnerToast(message, {
        icon: h(Icon, { name: 'tabler-info-octagon' }),
        class: 'border',
        closeButton: true,
        ...data,
    });
}

export function sonnerSuccess(message: string | Component, data?: ExternalToast) {
    sonnerToast(message, {
        icon: h(Icon, { name: 'tabler-check' }),
        class: '!bg-success !text-success-foreground',
        closeButton: true,
        ...data,
    });
}

export function sonnerError(message: string | Component, data?: ExternalToast) {
    sonnerToast(message, {
        icon: h(Icon, { name: 'tabler-x' }),
        class: '!bg-destructive !text-destructive-foreground',
        closeButton: true,
        ...data,
    });
}

export function sonnerWarning(message: string | Component, data?: ExternalToast) {
    sonnerToast(message, {
        icon: h(Icon, { name: 'tabler-alert-triangle' }),
        class: '!bg-warning !text-warning-foreground',
        closeButton: true,
        ...data,
    });
}

export { sonnerToast };
