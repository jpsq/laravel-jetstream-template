<script setup lang="ts">
    import { computed, ref, watch } from 'vue';

    const props = defineProps({
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

    const emit = defineEmits(['close']);
    const dialog = ref();
    const showSlot = computed({
        get: () => props.show,
        set: (value) => {
            if (!value && props.closeable) {
                emit('close');
            }
        },
    });

    const maxWidthClass = computed(() => {
        return {
            sm: 'sm:max-w-sm',
            md: 'sm:max-w-md',
            lg: 'sm:max-w-lg',
            xl: 'sm:max-w-xl',
            '2xl': 'sm:max-w-2xl',
        }[props.maxWidth];
    });
</script>

<template>
    <Dialog ref="dialog" v-model:open="showSlot">
        <DialogContent :class="maxWidthClass">
            <DialogHeader>
                <DialogTitle><slot name="title" /></DialogTitle>
                <DialogDescription> <slot name="description" /> </DialogDescription>
            </DialogHeader>
            <slot name="content" />
            <DialogFooter>
                <slot name="footer" />
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
