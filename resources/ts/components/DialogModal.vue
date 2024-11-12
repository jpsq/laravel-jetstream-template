<script setup lang="ts">
    import Modal from './Modal.vue';

    const emit = defineEmits(['close']);

    defineProps({
        show: {
            type: Boolean,
            default: false,
        },
        maxWidth: {
            type: String,
            default: '2xl',
        },
        closeable: {
            type: Boolean,
            default: true,
        },
    });

    const close = () => {
        emit('close');
    };
</script>

<template>
    <Modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
        <template #title><slot name="title" /></template>
        <template #description><slot name="description" /></template>
        <template #content><slot name="content" /></template>
        <template #footer><slot name="footer" /></template>
    </Modal>
</template>
