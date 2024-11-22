<script setup lang="ts">
    import { User } from '@/types';
    import { Link, router, useForm } from '@inertiajs/vue3';
    const props = defineProps<{ user: User }>();

    const form = useForm({
        _method: 'PUT',
        name: props.user.name,
        username: props.user.name,
        email: props.user.email,
        photo: null as File | null,
    });

    const verificationLinkSent = ref(false);
    const photoPreview = ref();
    const photoInput = ref<HTMLInputElement>();

    const updateProfileInformation = () => {
        if (photoInput.value) {
            form.photo = photoInput.value.files![0];
        }

        form.post(route('user-profile-information.update'), {
            errorBag: 'updateProfileInformation',
            preserveScroll: true,
            onSuccess: () => clearPhotoFileInput(),
        });
    };

    const sendEmailVerification = () => {
        verificationLinkSent.value = true;
    };

    const selectNewPhoto = () => {
        photoInput.value?.click();
    };

    const updatePhotoPreview = () => {
        const photo = photoInput.value?.files![0];

        if (!photo) return;

        const reader = new FileReader();

        reader.onload = (e) => {
            photoPreview.value = e.target?.result;
        };

        reader.readAsDataURL(photo);
    };

    const deletePhoto = () => {
        router.delete(route('current-user-photo.destroy'), {
            preserveScroll: true,
            onSuccess: () => {
                photoPreview.value = null;
                clearPhotoFileInput();
            },
        });
    };

    const clearPhotoFileInput = () => {
        if (photoInput.value?.value) {
            photoInput.value.files = null;
        }
    };
</script>

<template>
    <FormSection @submitted="updateProfileInformation">
        <template #title> Profile Information </template>
        <template #description> Update your account's profile information and email address. </template>

        <template #form>
            <!-- Profile Photo -->
            <div v-if="$page.props.jetstream.managesProfilePhotos" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input id="photo" ref="photoInput" type="file" class="hidden" @change="updatePhotoPreview" />
                <Label for="photo">Photo</Label>
                <div class="flex items-center gap-2">
                    <!-- Current Profile Photo -->
                    <div v-show="!photoPreview" class="mt-2">
                        <img :src="user.profile_photo_url" :alt="user.name" class="rounded-full h-20 w-20 object-cover border-2" />
                    </div>

                    <!-- New Profile Photo Preview -->
                    <div v-show="photoPreview" class="mt-2">
                        <span
                            class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center border"
                            :style="'background-image: url(\'' + photoPreview + '\');'"
                        />
                    </div>

                    <div>
                        <Button variant="outline" class="mt-2 me-2 block" type="button" @click.prevent="selectNewPhoto"> Select A New Photo </Button>
                        <Button variant="destructive" v-if="user.profile_photo_url" type="button" class="mt-2" @click.prevent="deletePhoto">
                            Remove Photo
                        </Button>
                    </div>
                </div>

                <InputError :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <Label for="name">Name</Label>
                <Input id="name" v-model="form.name" type="text" class="mt-1 block w-full" required autocomplete="name" />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <Label for="email">Email</Label>
                <Input id="email" v-model="form.email" type="email" class="mt-1 block w-full" required autocomplete="username" />
                <InputError :message="form.errors.email" class="mt-2" />

                <div v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
                    <p class="text-sm mt-2">
                        Your email address is unverified.
                        <Link
                            :href="route('verification.send')"
                            method="post"
                            as="button"
                            class="underline text-sm text-muted hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            @click.prevent="sendEmailVerification"
                        >
                            Click here to re-send the verification email.
                        </Link>
                    </p>

                    <div v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                        A new verification link has been sent to your email address.
                    </div>
                </div>
            </div>
        </template>

        <template #actions>
            <Button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> Save </Button>
            <ActionMessage :on="form.recentlySuccessful" class="me-3"> Saved. </ActionMessage>
        </template>
    </FormSection>
</template>
