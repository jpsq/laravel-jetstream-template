<script setup lang="ts">
    import { Head, Link } from '@inertiajs/vue3';
    import Placeholder from '@images/placeholder.svg';
    import Blank from '@/layouts/blank.vue';
    defineOptions({ layout: Blank });

    defineProps({
        canResetPassword: Boolean,
        status: String,
    });

    const form = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = () => {
        form.transform((data) => ({
            ...data,
            remember: form.remember ? 'on' : '',
        })).post(route('login'), {
            onFinish: () => form.reset('password'),
        });
    };
</script>

<template>
    <Head title="Login" />
    <div class="w-full lg:grid lg:grid-cols-2 flex-1">
        <div class="hidden bg-muted lg:block overflow-hidden">
            <img :src="Placeholder" alt="Image" class="h-full w-full object-cover dark:brightness-[0.2] dark:grayscale" />
        </div>
        <form @submit.prevent="submit" class="flex items-center justify-center py-12">
            <div class="mx-auto grid w-[350px] gap-6">
                <div class="grid gap-2 text-center">
                    <h1 class="text-xl font-bold">Login</h1>
                    <p class="text-balance text-muted-foreground">Enter your email below to login to your account</p>
                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                        {{ form.errors }}
                    </div>
                </div>
                <div class="grid gap-4">
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input v-model="form.email" id="email" type="email" placeholder="m@example.com" />
                        <InputError :message="form.errors.email" />
                    </div>
                    <div class="grid gap-2">
                        <div class="flex items-center">
                            <Label for="password">Password</Label>
                            <Link v-if="canResetPassword" :href="route('password.request')" class="ml-auto inline-block text-sm underline">
                                Forgot your password?
                            </Link>
                        </div>
                        <Input v-model="form.password" id="password" type="password" placeholder="********" />
                        <InputError :message="form.errors.password" />
                    </div>
                    <Button
                        type="submit"
                        class="w-full"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        append-icon="tabler-login"
                    >
                        Login
                    </Button>
                    <Button variant="outline" type="button" class="w-full" append-icon="tabler-brand-google"> Login with Google </Button>
                </div>
                <div class="mt-4 text-center text-sm">
                    Don't have an account?
                    <Button variant="link" type="button" :as="Link" :href="route('register')" class="underline"> Sign up </Button>
                </div>
            </div>
        </form>
    </div>
</template>
