<script setup lang="ts">
    import ApiTokenManager from '@/Pages/API/Partials/ApiTokenManager.vue';

    defineProps({
        tokens: Array,
        availablePermissions: Array,
        defaultPermissions: Array,
    });
</script>

<template>
    <div class="max-w-7xl mx-auto w-full pb-12">
        <ApiTokenManager :tokens="tokens" :available-permissions="availablePermissions" :default-permissions="defaultPermissions" />
    </div>
</template>
