<template>
    <span :class="cn('iconify font-semibold', name)"></span>
</template>

<script setup lang="ts">
    import { IconifyIconName } from '@/plugins/iconify/types';

    type Props = {
        name: IconifyIconName | string;
    };

    defineProps<Props>();
</script>
