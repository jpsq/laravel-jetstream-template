<template>
    <Link v-bind="props" :class="{ 'font-semibold text-primary': active }">
        <slot />
    </Link>
</template>
<script setup lang="ts">
    import { InertiaLinkProps, Link } from '@inertiajs/vue3';

    type Props = {
        active: boolean;
    } & InertiaLinkProps;

    const props = defineProps<Props>();
</script>
