<script setup lang="ts">
    import { useForm } from '@inertiajs/vue3';

    const props = defineProps<{
        tokens: any[];
        availablePermissions: any[];
        defaultPermissions: any[];
    }>();

    const createApiTokenForm = useForm({
        name: '',
        permissions: props.defaultPermissions,
    });

    const updateApiTokenForm = useForm({
        permissions: [],
    });

    const deleteApiTokenForm = useForm({});

    const displayingToken = ref(false);
    const managingPermissionsFor = ref(null);
    const apiTokenBeingDeleted = ref(null);

    const createApiToken = () => {
        createApiTokenForm.post(route('api-tokens.store'), {
            preserveScroll: true,
            onSuccess: () => {
                displayingToken.value = true;
                createApiTokenForm.reset();
            },
        });
    };

    const manageApiTokenPermissions = (token) => {
        updateApiTokenForm.permissions = token.abilities;
        managingPermissionsFor.value = token;
    };

    const updateApiToken = () => {
        updateApiTokenForm.put(route('api-tokens.update', managingPermissionsFor.value), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => (managingPermissionsFor.value = null),
        });
    };

    const confirmApiTokenDeletion = (token) => {
        apiTokenBeingDeleted.value = token;
    };

    const deleteApiToken = () => {
        console.log('deleteApiToken');
        deleteApiTokenForm.delete(route('api-tokens.destroy', apiTokenBeingDeleted.value), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => (apiTokenBeingDeleted.value = null),
        });
    };
</script>

<template>
    <div>
        <!-- Generate API Token -->
        <FormSection @submitted="createApiToken">
            <template #title> Create API Token </template>

            <template #description> API tokens allow third-party services to authenticate with our application on your behalf. </template>

            <template #form>
                <!-- Token Name -->
                <div class="col-span-6 sm:col-span-4">
                    <Label for="name">Name</Label>
                    <Input id="name" v-model="createApiTokenForm.name" type="text" placeholder="app-token-name" class="mt-1 block w-full" autofocus />
                    <InputError :message="createApiTokenForm.errors.name" class="mt-2" />
                </div>

                <!-- Token Permissions -->
                <div v-if="availablePermissions.length > 0" class="col-span-6">
                    <Label for="permissions">Permissions</Label>

                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div v-for="permission in availablePermissions" :key="permission">
                            <label class="flex items-center">
                                <Checkbox v-model:checked="createApiTokenForm.permissions" :value="permission" />
                                <span class="ms-2 text-sm text-muted-foreground">{{ permission }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </template>

            <template #actions>
                <Button :class="{ 'opacity-25': createApiTokenForm.processing }" :disabled="createApiTokenForm.processing"> Create </Button>
                <ActionMessage :on="createApiTokenForm.recentlySuccessful" class="me-3"> Created. </ActionMessage>
            </template>
        </FormSection>

        <div v-if="tokens.length > 0">
            <SectionBorder />

            <!-- Manage API Tokens -->
            <div class="mt-10 sm:mt-0">
                <ActionSection>
                    <template #title> Manage API Tokens </template>

                    <template #description> You may delete any of your existing tokens if they are no longer needed. </template>

                    <!-- API Token List -->
                    <template #content>
                        <div class="space-y-6">
                            <div v-for="token in tokens" :key="token.id" class="flex items-center justify-between">
                                <div class="break-all">
                                    {{ token.name }}
                                </div>

                                <div class="flex items-center ms-2">
                                    <div v-if="token.last_used_ago" class="text-sm text-gray-400">Last used {{ token.last_used_ago }}</div>

                                    <button
                                        v-if="availablePermissions.length > 0"
                                        class="cursor-pointer ms-6 text-sm text-gray-400 underline"
                                        @click="manageApiTokenPermissions(token)"
                                    >
                                        Permissions
                                    </button>

                                    <button class="cursor-pointer ms-6 text-sm text-red-500" @click="confirmApiTokenDeletion(token)">Delete</button>
                                </div>
                            </div>
                        </div>
                    </template>
                </ActionSection>
            </div>
        </div>

        <!-- Token Value Modal -->
        <Modal :show="displayingToken" @close="displayingToken = false">
            <template #title> API Token </template>

            <template #content>
                <div>Please copy your new API token. For your security, it won't be shown again.</div>

                <div
                    v-if="$page.props.jetstream.flash.token"
                    class="mt-4 bg-foreground/10 px-4 py-2 rounded font-mono text-sm text-gray-500 break-all"
                >
                    {{ $page.props.jetstream.flash.token }}
                </div>
            </template>

            <template #footer>
                <Button variant="outline" @click="displayingToken = false"> Close </Button>
            </template>
        </Modal>

        <!-- API Token Permissions Modal -->
        <Modal :show="managingPermissionsFor != null" @close="managingPermissionsFor = null">
            <template #title> API Token Permissions </template>

            <template #content>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div v-for="permission in availablePermissions" :key="permission">
                        <label class="flex items-center">
                            <Checkbox v-model:checked="updateApiTokenForm.permissions" :value="permission" />
                            <span class="ms-2 text-sm text-muted-foreground">{{ permission }}</span>
                        </label>
                    </div>
                </div>
            </template>

            <template #footer>
                <Button variant="outline" @click="managingPermissionsFor = null"> Cancel </Button>

                <Button
                    class="ms-3"
                    :class="{ 'opacity-25': updateApiTokenForm.processing }"
                    :disabled="updateApiTokenForm.processing"
                    @click="updateApiToken"
                >
                    Save
                </Button>
            </template>
        </Modal>

        <AlertDialog :open="!!apiTokenBeingDeleted">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle> Delete API Token </AlertDialogTitle>
                    <AlertDialogDescription> Are you sure you would like to delete this API token? </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel @click="apiTokenBeingDeleted = null">Cancel</AlertDialogCancel>
                    <AlertDialogAction
                        :class="{ 'opacity-25': deleteApiTokenForm.processing }"
                        :disabled="deleteApiTokenForm.processing"
                        @click="deleteApiToken"
                    >
                        Continue
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </div>
</template>
