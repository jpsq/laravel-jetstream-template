<script setup lang="ts">
    import { Head } from '@inertiajs/vue3';
    import Blank from '@/layouts/blank.vue';
    defineOptions({ layout: Blank });

    defineProps({
        policy: String,
    });
</script>

<template>
    <Head title="Privacy Policy" />

    <div class="font-sans text-gray-900 antialiased">
        <div class="pt-4 bg-gray-100">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white overflow-hidden sm:rounded-lg prose" v-html="policy" />
            </div>
        </div>
    </div>
</template>
