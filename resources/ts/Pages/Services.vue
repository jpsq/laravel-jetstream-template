<script setup>
    import { ref, defineAsyncComponent } from 'vue';
    import { Head, useForm } from '@inertiajs/vue3';

    const UnsplashServiceForm = defineAsyncComponent(() => import('@/components/ServiceForm/UnsplashServiceForm.vue'));
    const TenorServiceForm = defineAsyncComponent(() => import('@/components/ServiceForm/TenorServiceForm.vue'));
    const BunnyStorageServiceForm = defineAsyncComponent(() => import('@/components/ServiceForm/BunnyStorageServiceForm.vue'));

    const pageTitle = 'Third Party Services';

    const props = defineProps(['services']);

    const form = useForm(props.services);

    const tab = ref('unsplash');
</script>
<template>
    <Head :title="pageTitle" />

    <Tabs v-model="tab">
        <TabsList class="grid grid-cols-3 shadow-inner bg-foreground/10 mb-5 w-max">
            <TabsTrigger v-if="form.unsplash" value="unsplash">
                <div class="flex items-center justify-center gap-2">
                    <Icon name="tabler-brand-unsplash" />
                    <span>Unsplash</span>
                </div>
            </TabsTrigger>
            <TabsTrigger v-if="form.tenor" value="tenor">
                <div class="flex items-center justify-center gap-2">
                    <Icon name="tabler-gif" />
                    <span>Tenor</span>
                </div>
            </TabsTrigger>
            <TabsTrigger v-if="form.bunnyStorage" value="BunnyStorage">
                <div class="flex items-center justify-center gap-2">
                    <Icon name="tabler-cloud" />
                    <span>Bunny Storage</span>
                </div>
            </TabsTrigger>
        </TabsList>
        <TabsContent v-if="form.unsplash" value="unsplash" :as="UnsplashServiceForm" :form="form.unsplash"> </TabsContent>
        <TabsContent v-if="form.tenor" value="tenor" :as="TenorServiceForm" :form="form.tenor"> </TabsContent>
        <TabsContent v-if="form.bunnyStorage" value="BunnyStorage" :as="BunnyStorageServiceForm" :form="form.bunnyStorage"> </TabsContent>
    </Tabs>
</template>
