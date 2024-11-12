<script setup lang="ts">
    import { Primitive, type PrimitiveProps } from 'radix-vue';
    import { type ButtonVariants, buttonVariants } from '.';
    import { HTMLAttributes } from 'vue';

    interface Props extends PrimitiveProps {
        as?: any;
        variant?: ButtonVariants['variant'];
        size?: ButtonVariants['size'];
        class?: HTMLAttributes['class'];
        preppendIcon?: any;
        appendIcon?: any;
    }

    const props = withDefaults(defineProps<Props>(), {
        as: 'button',
    });
</script>

<template>
    <Primitive :as="props.as" :as-child="asChild" :class="cn(buttonVariants({ variant, size }), 'active:translate-y-px', props.class)">
        <template v-if="props.preppendIcon">
            <Icon :name="props.preppendIcon" />
        </template>
        <slot />
        <template v-if="props.appendIcon">
            <Icon :name="props.appendIcon" />
        </template>
    </Primitive>
</template>
