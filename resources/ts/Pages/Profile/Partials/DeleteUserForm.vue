<script setup lang="ts">
    import { useForm } from '@inertiajs/vue3';

    const confirmingUserDeletion = ref(false);
    const passwordInput = ref(null);

    const form = useForm({
        password: '',
    });

    const confirmUserDeletion = () => {
        confirmingUserDeletion.value = true;
    };

    const deleteUser = () => {
        form.delete(route('current-user.destroy'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onFinish: () => form.reset(),
        });
    };

    const closeModal = () => {
        confirmingUserDeletion.value = false;

        form.reset();
    };
</script>

<template>
    <ActionSection>
        <template #title> Delete Account </template>

        <template #description> Permanently delete your account. </template>

        <template #content>
            <div class="max-w-xl text-sm text-muted-foreground">
                Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download
                any data or information that you wish to retain.
            </div>
            <!-- Delete Account Confirmation Modal -->
            <Modal :show="confirmingUserDeletion" @close="closeModal">
                <template #title> Delete Account </template>

                <template #description>
                    Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently
                    deleted. Please enter your password to confirm you would like to permanently delete your account.
                </template>

                <template #content>
                    <div class="mt-4">
                        <Input
                            ref="passwordInput"
                            v-model="form.password"
                            type="password"
                            class="mt-1 block w-3/4"
                            placeholder="Password"
                            autocomplete="current-password"
                            @keyup.enter="deleteUser"
                        />

                        <InputError :message="form.errors.password" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <Button variant="outline" @click="closeModal"> Cancel </Button>

                    <Button
                        variant="destructive"
                        class="ms-3"
                        @click="deleteUser"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Delete Account
                    </Button>
                </template>
            </Modal>
        </template>
        <template #actions>
            <Button variant="destructive" @click="confirmUserDeletion"> Delete Account </Button>
        </template>
    </ActionSection>
</template>
