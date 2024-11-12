<script setup lang="ts">
    import Placeholder from '@images/placeholder.svg';
    import { Head, useForm, Link } from '@inertiajs/vue3';
    import Blank from '@/layouts/blank.vue';
    defineOptions({ layout: Blank });
    const props = defineProps({
        status: String,
    });

    const form = useForm({});

    const submit = () => {
        form.post(route('verification.send'));
    };
    const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <Head title="Verify Email" />
    <div class="w-full lg:grid lg:h-screen lg:grid-cols-2 xl:h-screen">
        <div class="hidden bg-muted lg:block overflow-hidden">
            <img :src="Placeholder" alt="Image" class="h-full w-full object-cover dark:brightness-[0.2] dark:grayscale" />
        </div>
        <form @submit.prevent="submit" class="flex items-center justify-center py-12">
            <div class="mx-auto grid w-[350px] gap-6">
                <div class="grid gap-2 text-center">
                    <h1 class="text-xl font-bold">Verify Email</h1>
                    <p v-if="verificationLinkSent" class="mb-4 font-medium text-sm text-green-600">
                        A new verification link has been sent to the email address you provided in your profile settings.
                    </p>
                    <p v-else class="text-muted-foreground">
                        Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive
                        the email, we will gladly send you another.
                    </p>
                </div>
                <div class="grid gap-4">
                    <Button type="submit" class="w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        >Resend Verification Email</Button
                    >
                </div>
                <div class="flex justify-center gap-4">
                    <Button variant="link" :as="Link" :href="route('profile.show')"> Edit Profile </Button>

                    <Button variant="link" :as="Link" :href="route('logout')" method="post"> Log Out </Button>
                </div>
            </div>
        </form>
    </div>
</template>
