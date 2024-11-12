<script setup lang="ts">
    import { useForm } from '@inertiajs/vue3';

    const props = defineProps({
        team: Object,
    });

    const confirmingTeamDeletion = ref(false);
    const form = useForm({});

    const confirmTeamDeletion = () => {
        confirmingTeamDeletion.value = true;
    };

    const deleteTeam = () => {
        form.delete(route('teams.destroy', props.team), {
            errorBag: 'deleteTeam',
        });
    };
</script>

<template>
    <ActionSection>
        <template #title> Delete Team </template>

        <template #description> Permanently delete this team. </template>

        <template #content>
            <div class="max-w-xl text-sm text-muted-foreground">
                Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this team, please download any data
                or information regarding this team that you wish to retain.
            </div>

            <div class="mt-5">
                <DangerButton @click="confirmTeamDeletion"> Delete Team </DangerButton>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <AlertDialog v-model:open="confirmingTeamDeletion">
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle> Delete Team </AlertDialogTitle>
                        <AlertDialogDescription>
                            Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently
                            deleted.</AlertDialogDescription
                        >
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <AlertDialogAction :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteTeam">
                            Continue
                        </AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </template>
    </ActionSection>
</template>
