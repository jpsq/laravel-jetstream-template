<script setup>
    import { computed, ref } from 'vue';
    import { Head } from '@inertiajs/vue3';
    import useMedia from '@/composables/useMedia';

    const { activeTab, tabs, isDownloading, isDeleting, downloadExternal, deletePermanently } = useMedia();

    const sources = [
        { name: 'uploads', component: defineAsyncComponent(() => import('@/components/Media/MediaUploads.vue')) },
        { name: 'stock', component: defineAsyncComponent(() => import('@/components/Media/MediaStock.vue')) },
        { name: 'gifs', component: defineAsyncComponent(() => import('@/components/Media/MediaGifs.vue')) },
    ];

    const sourceProperties = ref();

    const source = computed(() => sources.find((source) => source.name === activeTab.value));

    const selectedItems = computed(() => {
        return sourceProperties.value ? sourceProperties.value.selected : [];
    });

    const deselectAll = () => {
        sourceProperties.value.deselectAll();
    };

    const use = () => {
        const toDownload = activeTab.value !== 'uploads';

        if (toDownload) {
            downloadExternal(
                selectedItems.value.map((item) => {
                    const { id, url, download_data } = item;
                    return { id, url, download_data };
                }),
                (response) => {
                    createPost(response.data);
                }
            );
        }

        if (!toDownload) {
            createPost(selectedItems.value);
        }
    };

    const createPost = (media) => {
        console.log(media);
    };

    const confirmationDeletion = ref(false);

    const deleteSelectedItems = () => {
        const items = selectedItems.value.map((item) => item.id);

        deletePermanently(items, () => {
            deselectAll();
            sourceProperties.value.removeItems(items);
            confirmationDeletion.value = false;
        });
    };
</script>
<template>
    <Head title="Media Library" />

    <Tabs v-model="activeTab" class="h-full space-y-6">
            <TabsList class="grid grid-cols-3 shadow-inner bg-foreground/10 mb-5 w-max">
                <TabsTrigger :value="tabKey" v-for="(tabName, tabKey) in tabs" :key="tabKey"> {{ tabName }} </TabsTrigger>
            </TabsList>
        <component :is="source.component" v-bind="sourceProperties" ref="sourceProperties" />
    </Tabs>
    <SelectableBar :count="selectedItems?.length" @close="deselectAll()">
        <Button variant="secondary" @click="use" :isLoading="isDownloading" :disabled="isDownloading" class="mr-sm" size="sm">
            <Icon name="tabler-plus" class="mr-xs" />
            Create Post
        </Button>
        <template v-if="activeTab === 'uploads'">
            <Button variant="destructive" @click="confirmationDeletion = true" size="sm">
                <Icon name="tabler-trash" />
            </Button>
        </template>
    </SelectableBar>
    <!-- Delete Team Confirmation Modal -->
    <AlertDialog v-model:open="confirmationDeletion">
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>Delete media</AlertDialogTitle>
                <AlertDialogDescription> Are you sure you want to delete selected media items?</AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel>Cancel</AlertDialogCancel>
                <AlertDialogAction :class="{ 'opacity-25': isDeleting }" :disabled="isDeleting" @click="deleteSelectedItems">
                    Delete
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
