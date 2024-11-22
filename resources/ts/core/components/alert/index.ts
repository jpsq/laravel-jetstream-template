import { cva, type VariantProps } from 'class-variance-authority';

export { default as Alert } from './Alert.vue';
export { default as AlertDescription } from './AlertDescription.vue';
export { default as AlertTitle } from './AlertTitle.vue';

export const alertVariants = cva(
    [
        'relative w-full rounded-lg border p-4',
        '[&>svg~*]:pl-9 [&>svg+div]:translate-y-[-3px] [&>svg]:absolute [&>svg]:left-4 [&>svg]:top-4 [&>svg]:text-foreground',
        '[&>.iconify~*]:pl-9 [&>.iconify+div]:translate-y-[-3px] [&>.iconify]:absolute [&>.iconify]:left-4 [&>.iconify]:top-4 [&>.iconify]:text-foreground',
    ],
    {
        variants: {
            variant: {
                default: 'bg-background text-foreground',
                destructive: 'border-destructive/50 text-destructive dark:border-destructive [&>svg]:text-destructive [&>.iconify]:text-destructive',
                success: 'border-success/50 text-success dark:border-success [&>svg]:text-success [&>.iconify]:text-success',
                info: 'border-info/50 text-info dark:border-info [&>svg]:text-info [&>.iconify]:text-info',
                warning: 'border-warning/50 text-warning dark:border-warning [&>svg]:text-warning [&>.iconify]:text-warning',
            },
        },
        defaultVariants: {
            variant: 'default',
        },
    }
);

export type AlertVariants = VariantProps<typeof alertVariants>;
