<script setup lang="ts">
    import type { HTMLAttributes } from 'vue';
    import { cn } from '@/core/lib/utils';

    const props = defineProps<{
        class?: HTMLAttributes['class'];
        isMobile?: boolean;
    }>();
</script>

<template>
    <main
        :class="
            cn(
                isMobile
                    ? 'h-[calc(100svh-theme(spacing.16))] overflow-auto'
                    : 'min-h-svh peer-data-[variant=inset]:min-h-[calc(100svh-theme(spacing.4))]',
                'relative flex flex-1 flex-col bg-background md:peer-data-[variant=inset]:m-2 md:peer-data-[state=collapsed]:peer-data-[variant=inset]:ml-2 md:peer-data-[variant=inset]:ml-0 md:peer-data-[variant=inset]:rounded-xl md:peer-data-[variant=inset]:shadow',
                props.class
            )
        "
    >
        <slot />
    </main>
</template>
