<script setup lang="ts">
    import { Head } from '@inertiajs/vue3';
    import Blank from '@/layouts/blank.vue';
    defineOptions({ layout: Blank });

    defineProps({
        terms: String,
    });
</script>

<template>
    <Head title="Terms of Service" />
    <div class="font-sansantialiased">
        <div class="pt-4 bg-background">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-surface overflow-hidden sm:rounded-lg prose dark:prose-invert" v-html="terms" />
            </div>
        </div>
    </div>
</template>
