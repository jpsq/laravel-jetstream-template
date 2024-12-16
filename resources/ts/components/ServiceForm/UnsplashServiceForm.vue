<script setup>
    import { ref } from 'vue';
    import { router } from '@inertiajs/vue3';


    const props = defineProps({
        form: {
            required: true,
            type: Object,
        },
    });

    const errors = ref({});
    const formData = useForm(props.form);

    const save = () => {
        errors.value = {};
        formData.put(route('services.update', { service: 'unsplash' }), {
            preserveScroll: true,
            onSuccess() {
                sonnerSuccess( 'Unsplash credentials have been saved');
            },
            onError: (err) => {
                errors.value = err;
            },
        });
    };
</script>
<template>
    <FormSection @submitted="save">
        <template #title>
            <span class="mr-xs"><Icon name="tabler-brand-unsplash" class="text-black" /></span>
            <span>Unsplash</span>
        </template>
        <template #description>
            <p>With Unsplash you can use external stock photos directly in Mixpost.</p>
            <p>
                Create an App on
                <a href="https://unsplash.com/oauth/applications" class="link text-info hover:underline" target="_blank">Unsplash</a>.
            </p>
            <ReadDocHelp href="https://unsplash.com/documentation" class="mt-xs" />
        </template>
        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <Label for="API-Key">API Key</Label>
                <Input id="API-Key" v-model="formData.client_id" type="text" autocomplete="off" placeholder="********" class="mt-1 block w-full" />
                <InputError :message="errors.client_id" class="mt-2" />
            </div>
        </template>
        <template #actions>
            <Button :class="{ 'opacity-25': formData.processing }" :disabled="formData.processing"> Save </Button>
            <ActionMessage :on="formData.recentlySuccessful" class="ml-3"> Saved. </ActionMessage>
        </template>
    </FormSection>
</template>
