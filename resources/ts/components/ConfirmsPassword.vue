<script setup lang="ts">
    import InputError from './InputError.vue';

    const emit = defineEmits(['confirmed']);

    defineProps({
        title: {
            type: String,
            default: 'Confirm Password',
        },
        content: {
            type: String,
            default: 'For your security, please confirm your password to continue.',
        },
        button: {
            type: String,
            default: 'Confirm',
        },
    });

    const confirmingPassword = ref(false);

    const form = reactive({
        password: '',
        error: '',
        processing: false,
    });

    const passwordInput = ref(null);

    const startConfirmingPassword = () => {
        axios.get(route('password.confirmation')).then((response) => {
            if (response.data.confirmed) {
                emit('confirmed');
            } else {
                confirmingPassword.value = true;
            }
        });
    };

    const confirmPassword = () => {
        console.log(passwordInput.value);
        form.processing = true;

        axios
            .post(route('password.confirm'), {
                password: form.password,
            })
            .then(() => {
                form.processing = false;

                closeModal();
                nextTick().then(() => emit('confirmed'));
            })
            .catch((error) => {
                form.processing = false;
                form.error = error.response.data.errors.password[0];
            });
    };

    const closeModal = () => {
        confirmingPassword.value = false;
        form.password = '';
        form.error = '';
    };
</script>

<template>
    <span>
        <span @click="startConfirmingPassword">
            <slot />
        </span>

        <Modal :show="confirmingPassword" @close="closeModal">
            <template #title>{{ title }}</template>

            <template #description> {{ content }}</template>

            <template #content>
                <div class="mt-4">
                    <Input
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="Password"
                        autocomplete="current-password"
                        @keyup.enter="confirmPassword"
                    />

                    <InputError :message="form.error" class="mt-2" />
                </div>
            </template>

            <template #footer>
                <Button variant="outline" @click="closeModal"> Cancel </Button>
                <Button class="ms-3" @click="confirmPassword">
                    {{ button }}
                </Button>
            </template>
        </Modal>
    </span>
</template>
