<script setup lang="ts">
    import { Head, Link } from '@inertiajs/vue3';
    import Placeholder from '@images/placeholder.svg';
    import Blank from '@/layouts/blank.vue';
    defineOptions({ layout: Blank });

    defineProps<{ jetstream: any }>();

    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        terms: false,
    });

    const submit = () => {
        form.post(route('register'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };
</script>

<template>
    <Head title="Register" />
    <div class="w-full lg:grid lg:grid-cols-2 flex-1">
        <div class="hidden bg-muted lg:block overflow-hidden">
            <img :src="Placeholder" alt="Image" class="h-full w-full object-cover dark:brightness-[0.2] dark:grayscale" />
        </div>
        <form @submit.prevent="submit" class="flex items-center justify-center py-12">
            <div class="mx-auto grid w-[350px] gap-6">
                <div class="grid gap-2 text-center">
                    <h1 class="text-xl font-bold">Register</h1>
                    <p class="text-balance text-muted-foreground">Enter your email below to create a new account</p>
                </div>
                <div class="grid gap-4">
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input v-model="form.name" id="name" placeholder="John Doe" autofocus autocomplete="name" />
                        <InputError :message="form.errors.name" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input v-model="form.email" id="email" type="email" placeholder="m@example.com" autocomplete="username" />
                        <InputError :message="form.errors.email" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="password">Password</Label>
                        <Input v-model="form.password" id="password" type="password" autocomplete="new-password" placeholder="********" />
                        <InputError :message="form.errors.password" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="password_confirmation">Confirm Password</Label>
                        <Input
                            v-model="form.password_confirmation"
                            id="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            placeholder="********"
                        />
                        <InputError :message="form.errors.password_confirmation" />
                    </div>
                    <div v-if="jetstream.hasTermsAndPrivacyPolicyFeature">
                        <Label for="terms">
                            <div class="flex items-center">
                                <Checkbox id="terms" v-model:checked="form.terms" name="terms" />
                                <div class="ms-2">
                                    I agree to the
                                    <Button variant="link" as="a" target="_blank" class="px-0" :href="route('terms.show')">Terms of Service</Button>
                                    and
                                    <Button variant="link" as="a" target="_blank" class="px-0" :href="route('policy.show')">Privacy Policy</Button>
                                </div>
                            </div>
                            <InputError class="mt-2" :message="form.errors.terms" />
                        </Label>
                    </div>
                    <Button type="submit" class="w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> Register </Button>
                </div>

                <div class="mt-4 text-center text-sm">
                    Already have an account?
                    <Link :href="route('login')" class="underline"> Sign in </Link>
                </div>
            </div>
        </form>
    </div>
</template>
