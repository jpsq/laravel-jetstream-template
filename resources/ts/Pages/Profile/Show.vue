<script setup lang="ts">
    import DeleteUserForm from './Partials/DeleteUserForm.vue';
    import LogoutOtherBrowserSessionsForm from './Partials/LogoutOtherBrowserSessionsForm.vue';
    import NavbarLink from './Partials/NavbarLink.vue';
    import TwoFactorAuthenticationForm from './Partials/TwoFactorAuthenticationForm.vue';
    import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
    import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

    defineProps({
        confirmsTwoFactorAuthentication: Boolean,
        sessions: Array,
    });
    const activeTab = computed(() => route().params.tab ?? 'generale');
</script>

<template>
    <div class="max-w-7xl mx-auto w-full pb-12">
        <Tabs default-value="generale">
            <TabsList class="grid grid-cols-2 w-64 shadow-inner bg-foreground/10">
                <TabsTrigger value="generale" class="data-[state=active]:bg-surface"> Generale </TabsTrigger>
                <TabsTrigger value="security"> Security </TabsTrigger>
            </TabsList>
            <TabsContent value="generale">
                <div class="mb-5" v-if="$page.props.jetstream.canUpdateProfileInformation">
                    <UpdateProfileInformationForm :user="$page.props.auth.user" />
                </div>
                <div class="mb-5" v-if="$page.props.jetstream.hasAccountDeletionFeatures">
                    <DeleteUserForm class="mt-10 sm:mt-0" />
                </div>
            </TabsContent>

            <TabsContent value="security">
                <div class="mb-5" v-if="$page.props.jetstream.canUpdatePassword">
                    <UpdatePasswordForm class="mt-10 sm:mt-0" />
                </div>
                <div class="mb-5" v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
                    <TwoFactorAuthenticationForm :requires-confirmation="confirmsTwoFactorAuthentication" class="mt-10 sm:mt-0" />
                </div>
                <LogoutOtherBrowserSessionsForm :sessions="sessions" class="mt-10 sm:mt-0" />
            </TabsContent>
        </Tabs>
    </div>
</template>
