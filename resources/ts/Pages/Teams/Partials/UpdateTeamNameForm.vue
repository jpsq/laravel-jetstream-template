<script setup lang="ts">
    import { useForm } from '@inertiajs/vue3';

    const props = defineProps({
        team: Object,
        permissions: Object,
    });

    const form = useForm({
        name: props.team.name,
    });

    const updateTeamName = () => {
        form.put(route('teams.update', props.team), {
            errorBag: 'updateTeamName',
            preserveScroll: true,
        });
    };
</script>

<template>
    <FormSection @submitted="updateTeamName">
        <template #title> Team Name </template>

        <template #description> The team's name and owner information. </template>

        <template #form>
            <!-- Team Owner Information -->
            <div class="col-span-6">
                <Label>Team Owner</Label>

                <div class="flex items-center mt-2">
                    <Avatar class="h-12 w-12 rounded-lg">
                        <AvatarImage :src="team.owner.profile_photo_url" :alt="team.owner.name" />
                        <AvatarFallback class="rounded-lg">{{ team.owner.name[0] }}</AvatarFallback>
                    </Avatar>

                    <div class="ms-4 leading-tight">
                        <div class="text-accent-foreground">{{ team.owner.name }}</div>
                        <div class="text-muted-foreground text-sm">
                            {{ team.owner.email }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Name -->
            <div class="col-span-6 sm:col-span-4">
                <Label for="name">Team Name</Label>
                <Input id="name" v-model="form.name" type="text" class="mt-1 block w-full" :disabled="!permissions.canUpdateTeam" />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template v-if="permissions.canUpdateTeam" #actions>
            <Button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> Save </Button>
            <ActionMessage :on="form.recentlySuccessful" class="me-3"> Saved. </ActionMessage>
        </template>
    </FormSection>
</template>
