<script setup lang="ts">
    import { Head, useForm } from '@inertiajs/vue3';
    import Placeholder from '@images/placeholder.svg';
    import Blank from '@/layouts/blank.vue';
    defineOptions({ layout: Blank });

    const form = useForm({
        password: '',
    });

    const submit = () => {
        form.post(route('password.confirm'), {
            onFinish: () => {
                form.reset();
            },
        });
    };
</script>

<template>
    <Head title="Secure Area" />

    <div class="w-full lg:grid lg:h-screen lg:grid-cols-2 xl:h-screen">
        <div class="hidden bg-muted lg:block overflow-hidden">
            <img :src="Placeholder" alt="Image" class="h-full w-full object-cover dark:brightness-[0.2] dark:grayscale" />
        </div>
        <form @submit.prevent="submit" class="flex items-center justify-center py-12">
            <div class="mx-auto grid w-[350px] gap-6">
                <div class="grid gap-2 text-center">
                    <h1 class="text-xl font-bold">Secure Area</h1>
                    <div class="mb-4 text-sm text-gray-600">
                        This is a secure area of the application. Please confirm your password before continuing.
                    </div>
                </div>
                <div class="grid gap-4">
                    <div class="grid gap-2">
                        <Label for="email">Password</Label>
                        <Input v-model="form.password" id="password" autocomplete="new-password" type="password" placeholder="**********" />
                        <InputError :message="form.errors.password" />
                    </div>

                    <Button type="submit" class="w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Reset Password
                    </Button>
                </div>
            </div>
        </form>
    </div>
</template>
