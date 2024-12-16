<template>
    <div>
        <h1>create</h1>
        <span v-if="isLoading">Loading</span>
        <img v-else :src="src" />
    </div>
</template>
<script setup lang="ts">
    // import { useImageLoadingStatus } from 'radix-vue/dist/Avatar/utils';

    const src =
        'https://images.unsplash.com/photo-1499714608240-22fc6ad53fb2?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=76&q=80';
    const { state, isLoading } = useImage({
        src,
    });

    console.log(state.value);
</script>
