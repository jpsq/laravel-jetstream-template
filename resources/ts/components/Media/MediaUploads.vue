<script setup>
    import { onMounted } from 'vue';
    import useMedia from '@/composables/useMedia';

    defineOptions({ inheritAttrs: false });

    const props = defineProps({
        columns: {
            type: Number,
            default: 3,
        },
    });

    const { items, endlessPagination, isFetching, selected, keyword, toggleSelect, deselectAll, removeItems, isSelected, createObserver } =
        useMedia();

    onMounted(createObserver);

    defineExpose({ selected, deselectAll, removeItems });
</script>
<template>
    <UploadMedia
        :max-selection="4"
        :combines-mime-types="''"
        :selected="selected"
        :toggleSelect="toggleSelect"
        :isSelected="isSelected"
        :columns="columns"
    />
    <Separator class="my-4" />
    <div>
        <div class="flex items-center justify-between mb-6">
            <div class="space-y-1">
                <h2 class="text-2xl font-semibold tracking-tight">Uploads</h2>
                <p class="text-sm text-muted-foreground">Upload your media files</p>
            </div>
            <Input v-model="keyword" placeholder="Search Unsplash" class="max-w-xs" />
        </div>
        <template v-if="items.length">
            <Masonry :items="items" :columns="columns">
                <template #default="{ item }">
                    <MediaSelectable v-if="item" :active="isSelected(item)" @click="toggleSelect(item)">
                        <MediaFile :media="item" class="group">
                            <template #loader>
                                <Skeleton class="w-full aspect-video rounded-xl bg-surface shadow-mix" />
                            </template>
                            <MediaCredit>
                                <p class="truncate">
                                    {{ item.name }}
                                </p>
                            </MediaCredit>
                        </MediaFile>
                    </MediaSelectable>
                </template>
            </Masonry>
        </template>

        <div class="grid gap-6" v-if="isFetching" :style="{ gridTemplateColumns: `repeat(${columns}, minmax(0, 1fr))` }">
            <div class="flex flex-col space-y-3" v-for="(item, index) in columns * 3" :key="index">
                <Skeleton class="w-full aspect-video rounded-xl bg-surface shadow-mix" />
                <div class="space-y-2">
                    <Skeleton class="h-4 w-full bg-surface shadow-mix" />
                    <Skeleton class="h-4 w-full bg-surface shadow-mix" />
                </div>
            </div>
        </div>

        <div ref="endlessPagination" class="-z-10 w-full h-1" />
    </div>
</template>
