<script setup>
    defineProps({
        active: {
            type: Boolean,
            default: false,
        },
    });

    defineEmits(['click']);
</script>
<template>
    <div @click="$emit('click')" class="w-full relative cursor-pointer box-border">
        <slot />
        <div class="absolute flex items-center justify-center top-1 right-1 bg-foreground/20 rounded-lg" :class="{ 'bg-primary': active }">
            <Icon :name="active ? 'tabler-check' : 'tabler-square-rounded'" class="text-primary-foreground"/>
        </div>
    </div>
</template>
