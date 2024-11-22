<script setup lang="ts">
    import Blank from '@/layouts/blank.vue';
    import Placeholder from '@images/placeholder.svg';
    import { Head, useForm } from '@inertiajs/vue3';
    defineOptions({ layout: Blank });
    defineProps({
        status: String,
    });

    const form = useForm({
        email: '',
    });

    const submit = () => {
        form.post(route('password.email'));
    };
</script>

<template>
    <Head title="Forgot Password" />
    <div class="w-full lg:grid lg:grid-cols-2 flex-1">
        <div class="hidden bg-muted lg:block overflow-hidden">
            <img :src="Placeholder" alt="Image" class="h-full w-full object-cover dark:brightness-[0.2] dark:grayscale" />
        </div>
        <form @submit.prevent="submit" class="flex items-center justify-center py-12">
            <div class="mx-auto grid w-[350px] gap-6">
                <div class="grid gap-2 text-center">
                    <h1 class="text-xl font-bold">Forgot Password</h1>
                    <p class="text-muted-foreground">
                        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.
                    </p>
                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                        {{ status }}
                    </div>
                </div>
                <div class="grid gap-4">
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input v-model="form.email" id="email" type="email" placeholder="m@example.com" />
                        <InputError :message="form.errors.email" />
                    </div>
                    <Button type="submit" class="w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Submit Reset Link</Button
                    >
                </div>
            </div>
        </form>
    </div>
</template>
