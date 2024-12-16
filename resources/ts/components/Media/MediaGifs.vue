<script setup>
    import { computed, onMounted } from 'vue';
    import { usePage, Link } from '@inertiajs/vue3';
    import useMedia from '@/composables/useMedia';

    defineOptions({ inheritAttrs: false });

    const props = defineProps({
        columns: {
            type: Number,
            default: 3,
        },
    });

    const enabled = computed(() => {
        return usePage().props.is_configured_service.tenor;
    });

    const { isLoaded, keyword, page, items, isFetching, endlessPagination, selected, toggleSelect, deselectAll, isSelected, createObserver } =
        useMedia('media.fetchGifs');

    onMounted(() => {
        if (enabled.value) {
            createObserver();
        }
    });

    defineExpose({ selected, deselectAll });
</script>
<template>
    <div v-if="enabled">
        <div class="flex items-center justify-between mb-6">
            <div class="space-y-1">
                <h2 class="text-2xl font-semibold tracking-tight">GIFs from Tenor</h2>
                <p class="text-sm text-muted-foreground">Upload GIFs from Tenor</p>
            </div>
            <Input v-model="keyword" placeholder="Search Tenor" class="max-w-xs" />
        </div>

        <div v-if="items.length" class="">
            <Masonry :items="items" :columns="columns">
                <template #default="{ item }">
                    <MediaSelectable v-if="item" :active="isSelected(item)" @click="toggleSelect(item)">
                        <MediaFile :media="item" :key="item.id" class="group">
                            <template #loader>
                                <Skeleton class="w-full aspect-video rounded-xl bg-surface shadow-mix" />
                            </template>
                            <MediaCredit> GIF from Tenor </MediaCredit>
                        </MediaFile>
                    </MediaSelectable>
                </template>
            </Masonry>
        </div>

        <div class="grid gap-6" v-if="isFetching" :style="{ gridTemplateColumns: `repeat(${columns}, minmax(0, 1fr))` }">
            <div class="flex flex-col space-y-3" v-for="(item, index) in columns * 3" :key="index">
                <Skeleton class="w-full aspect-video rounded-xl bg-surface shadow-mix" />
                <div class="space-y-2">
                    <Skeleton class="h-4 w-full bg-surface shadow-mix" />
                    <Skeleton class="h-4 w-full bg-surface shadow-mix" />
                </div>
            </div>
        </div>

        <div class="flex items-center" v-if="isLoaded && !items.length">
            <div class="w-8 h-8 bg-cyan-100 text-cyan-600 rounded-full flex items-center justify-center mr-xs">
                <Icon name="tabler-exclamation-circle" />
            </div>
            <div>No GIFs found.</div>
        </div>

        <div ref="endlessPagination" class="-z-10 w-full h-1" />
    </div>
    <template v-else>
        <Alert variant="warning">
            <Icon name="tabler-alert-circle" class="w-4 h-4" />
            <AlertTitle> Unconfigured </AlertTitle>
            <AlertDescription> You have not configured Tenor service. </AlertDescription>
        </Alert>

        <Link :href="route('services.index')" class="block mt-4">
            <Button>Click to configure</Button>
        </Link>
    </template>
</template>
