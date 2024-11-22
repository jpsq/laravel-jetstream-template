<script setup>
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

        formData.put(route('services.update', { service: 'tenor' }), {
            preserveScroll: true,
            onSuccess() {
                sonnerSuccess('Tenor credentials have been saved');
            },
            onError: (err) => {
                errors.value = err;
            },
        });
    };
</script>
<template>
    <FormSection @submitted="save">
        <template #title class="flex items-center">
            <span class="mr-xs"><Icon name="tabler-gif" class="text-black" /></span>
            <span>Tenor</span>
        </template>
        <template #description>
            <p>With Tenor you can use GIF's directly.</p>
            <p>
                Create an App on
                <a href="https://console.cloud.google.com/" class="link text-info hover:underline" target="_blank">Google Console</a>.
            </p>
            <ReadDocHelp href="/services/tenor/documentation" class="mt-xs" />
        </template>
        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <Label for="API-Key">API Key</Label>
                <Input id="API-Key" v-model="form.client_id" type="text" autocomplete="off" placeholder="********" class="mt-1 block w-full" />
                <InputError :message="errors.client_id" class="mt-2" />
            </div>
        </template>
        <template #actions>
            <Button :class="{ 'opacity-25': formData.processing }" :disabled="formData.processing"> Save </Button>
            <ActionMessage :on="formData.recentlySuccessful" class="ml-3"> Saved. </ActionMessage>
        </template>
    </FormSection>
</template>
