<script setup lang="ts">
    import { useForm } from '@inertiajs/vue3';

    const form = useForm({
        name: '',
    });

    const createTeam = () => {
        form.post(route('teams.store'), {
            errorBag: 'createTeam',
            preserveScroll: true,
        });
    };
</script>

<template>
    <FormSection @submitted="createTeam">
        <template #title> Team Details </template>

        <template #description> Create a new team to collaborate with others on projects. </template>

        <template #form>
            <div class="col-span-6">
                <Label>Team Owner</Label>

                <div class="flex items-center mt-2">
                    <img
                        class="object-cover w-12 h-12 rounded-full"
                        :src="$page.props.auth.user.profile_photo_url"
                        :alt="$page.props.auth.user.name"
                    />

                    <div class="ms-4 leading-tight">
                        <div class="text-accent-foreground">{{ $page.props.auth.user.name }}</div>
                        <div class="text-sm text-muted-foreground">
                            {{ $page.props.auth.user.email }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <Label for="name">Team Name</Label>
                <Input id="name" v-model="form.name" placeholder="Team Name" type="text" class="block w-full mt-1" autofocus />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <Button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> Create </Button>
        </template>
    </FormSection>
</template>
