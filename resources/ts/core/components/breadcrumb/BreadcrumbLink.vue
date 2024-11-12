<script lang="ts" setup>
    import type { HTMLAttributes } from 'vue';
    import { cn } from '@/core/lib/utils';
    import { Primitive, type PrimitiveProps } from 'radix-vue';

    interface Props extends PrimitiveProps {
        class?: HTMLAttributes['class'];
    }

    const props = withDefaults(defineProps<Props>(), {
        as: 'a',
    });
</script>

<template>
    <Primitive :as="as" :as-child="asChild" :class="cn('transition-colors hover:text-foreground', props.class)">
        <slot />
    </Primitive>
</template>
