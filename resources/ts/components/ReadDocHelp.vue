<script setup>
import { Link } from '@inertiajs/vue3';

    defineProps({
        href: {
            type: String,
            default: '#',
        },
    });
</script>
<template>
    <div class="flex items-center">
        <Icon name="tabler-help" class="!w-4 !h-4 mr-xs" />
        <span>Read the <a :href="href" target="_blank" class="link text-info hover:underline">documentation</a>.</span>
    </div>
</template>
