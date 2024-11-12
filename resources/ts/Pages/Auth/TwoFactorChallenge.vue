<script setup lang="ts">
    import { Head, Link } from '@inertiajs/vue3';
    import Placeholder from '@images/placeholder.svg';
    import Blank from '@/layouts/blank.vue';
    defineOptions({ layout: Blank });

    const recovery = ref(false);

    const form = useForm({
        code: [''],
        recovery_code: '',
    });

    const toggleRecovery = async () => {
        recovery.value = !recovery.value;
        form.reset();
        await nextTick();
    };

    const submit = () => {
        form.transform((data) => ({ ...data, code: data.code.join('') })).post(route('two-factor.login'));
    };
</script>

<template>
    <Head title="Two-factor Confirmation" />
    <div class="w-full lg:grid lg:h-screen lg:grid-cols-2 xl:h-screen">
        <div class="hidden bg-muted lg:block overflow-hidden">
            <img :src="Placeholder" alt="Image" class="h-full w-full object-cover dark:brightness-[0.2] dark:grayscale" />
        </div>
        <form @submit.prevent="submit" class="flex items-center justify-center py-12">
            <div class="mx-auto grid w-[350px] gap-6">
                <div class="grid gap-2 text-center">
                    <h1 class="text-xl font-bold">Two-factor Confirmation</h1>
                    <p class="text-balance text-muted-foreground">
                        <template v-if="!recovery">
                            Please confirm access to your account by entering the authentication code provided by your authenticator application.
                        </template>

                        <template v-else> Please confirm access to your account by entering one of your emergency recovery codes. </template>
                    </p>
                </div>
                <div class="grid gap-4">
                    <div class="grid gap-2" v-if="!recovery">
                        <Label for="code">Code</Label>
                        <PinInput id="pin-input" v-model="form.code" placeholder="-" @complete="submit">
                            <PinInputGroup>
                                <PinInputInput v-for="(id, index) in 6" class="w-full" :key="id" :index="index" />
                            </PinInputGroup>
                        </PinInput>
                        <InputError :message="form.errors.code" />
                    </div>
                    <div class="grid gap-2" v-else>
                        <Label for="recovery_code">Recovery Code</Label>
                        <Input
                            v-model="form.recovery_code"
                            id="recovery_code"
                            type="text"
                            autocomplete="one-time-code"
                            placeholder="XXXXXXXXXX-XXXXXXXXXX"
                        />
                        <InputError :message="form.errors.recovery_code" />
                    </div>

                    <div class="flex justify-between mt-4">
                        <Button variant="link" @click.prevent="toggleRecovery">
                            <template v-if="!recovery"> Use a recovery code </template>
                            <template v-else> Use an authentication code </template>
                        </Button>
                        <Button class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> Log in </Button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
