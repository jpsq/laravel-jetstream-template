<script setup>
    import { computed } from 'vue';

    const props = defineProps({
        media: {
            type: Object,
            required: true,
        },
        imgHeight: {
            type: String,
            default: 'full',
        },
        imgWidthFull: {
            type: Boolean,
            default: true,
        },
    });

    const imgHeightClass = computed(() => {
        switch (props.imgHeight) {
            case 'full':
                return 'h-full';
            case 'sm':
                return 'h-20';
            default:
                return 'h-full';
        }
    });

    const { state, isLoading, error } = useImage({ src: props.media.thumb_url });
</script>
<template>
    <figure class="relative overflow-hidden rounded-md">
        <slot />

        <slot v-if="isLoading" name="loader" />
        <template v-else>
            <div class="relative flex rounded" :class="{ 'border border-red-500 p-5': media.hasOwnProperty('error') }">
                <span v-if="media.is_video" class="absolute top-0 right-0 mt-1 mr-1">
                    <Icon name="tabler-video" class="!w-4 !h-4 text-white" />
                </span>
                <div v-if="media.hasOwnProperty('error') || error" class="text-center">
                    <Icon name="tabler-exclamation-mark" class="w-8 h-8 mx-auto text-red-500" />
                    <div class="mt-xs">{{ media.name }}</div>
                    <div class="mt-xs text-red-500">{{ media.error ? media.error : $t('media.error_uploading_media') }}</div>
                </div>
                <img
                    v-else
                    :src="media.thumb_url"
                    loading="lazy"
                    :alt="media.name"
                    class="rounded-md object-cover transition-all hover:scale-105"
                    :class="[imgHeightClass, { 'w-full': imgWidthFull }]"
                />
            </div>
        </template>
    </figure>
</template>

<style scoped>
    /* figure {
        min-height: min(20vh, 100dvh);
    } */
</style>
