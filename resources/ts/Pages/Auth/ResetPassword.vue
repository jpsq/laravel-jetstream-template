<script setup lang="ts">
    import Blank from '@/layouts/blank.vue';
    import Placeholder from '@images/placeholder.svg';
    import { Head, useForm } from '@inertiajs/vue3';
    defineOptions({ layout: Blank });
    const props = defineProps({
        email: String,
        token: String,
    });

    const form = useForm({
        token: props.token,
        email: props.email,
        password: '',
        password_confirmation: '',
    });

    const submit = () => {
        form.post(route('password.update'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };
</script>

<template>
    <Head title="Reset Password" />
    <div class="w-full lg:grid lg:h-screen lg:grid-cols-2 xl:h-screen">
        <div class="hidden bg-muted lg:block overflow-hidden">
            <img :src="Placeholder" alt="Image" class="h-full w-full object-cover dark:brightness-[0.2] dark:grayscale" />
        </div>
        <form @submit.prevent="submit" class="flex items-center justify-center py-12">
            <div class="mx-auto grid w-[350px] gap-6">
                <div class="grid gap-2 text-center">
                    <h1 class="text-xl font-bold">Reset Password</h1>
                </div>
                <div class="grid gap-4">
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input v-model="form.email" id="email" type="email" placeholder="m@example.com" />
                        <InputError :message="form.errors.email" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="email">Password</Label>
                        <Input v-model="form.password" id="password" autocomplete="new-password" type="password" placeholder="**********" />
                        <InputError :message="form.errors.password" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="email">Confirm Password</Label>
                        <Input
                            v-model="form.password_confirmation"
                            id="password_confirmation"
                            autocomplete="new-password"
                            type="password"
                            placeholder="**********"
                        />
                        <InputError :message="form.errors.password_confirmation" />
                    </div>
                    <Button type="submit" class="w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        >Reset Password</Button
                    >
                </div>
            </div>
        </form>
    </div>
</template>
