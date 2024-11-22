<script setup>
    defineProps({
        count: {
            type: Number,
            required: true,
        },
    });
</script>
<template>
    <transition
        enter-active-class="transition ease-out duration-200"
        enter-from-class="transform opacity-0 scale-95"
        enter-to-class="transform opacity-100 scale-100"
        leave-active-class="transition ease-in duration-75"
        leave-from-class="transform opacity-100 scale-100"
        leave-to-class="transform opacity-0 scale-95"
    >

        <div v-show="count" class="fixed bottom-0 mb-sm py-md px-sm flex items-center bg-foreground/60 shadow-mix text-accent rounded-md mt-1 z-[9999999999] backdrop-blur-sm">
            <div class="flex w-full items-center">
                <div class="flex items-center">
                    <button
                        @click="$emit('close')"
                        class="mr-sm hover:text-red-500 transition-colors ease-in-out duration-200"
                    >
                        <Icon name="tabler-x" />
                    </button>
                    <div class="text-white-base">
                        <span class="btn-black mr-xs">{{ count }}</span>
                        <span class="hidden sm:inline-block">items selected</span>
                        <span class="inline-block sm:hidden">selected</span>
                    </div>
                </div>
                <div :class="{ 'ml-sm': $slots }" class="flex items-center">
                    <slot />
                </div>
            </div>
        </div>
    </transition>
</template>
