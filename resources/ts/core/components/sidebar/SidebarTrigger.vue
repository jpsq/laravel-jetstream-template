<script setup lang="ts">
    import type { HTMLAttributes } from 'vue';
    import { cn } from '@/core/lib/utils';
    import { useSidebar } from './utils';

    const props = defineProps<{
        class?: HTMLAttributes['class'];
    }>();

    const { toggleSidebar, open } = useSidebar();
</script>

<template>
    <Button data-sidebar="trigger" variant="ghost" size="icon" :class="cn('h-7 w-7', props.class)" @click="toggleSidebar">
        <svg stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path
                :class="{ hidden: open, 'inline-flex': !open }"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
            />
            <path
                :class="{ hidden: !open, 'inline-flex': open }"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
            />
        </svg>
        <span class="sr-only">Toggle Sidebar</span>
    </Button>
</template>
