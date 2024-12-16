<script setup>
    import { usePage } from '@inertiajs/vue3';
    import emitter from '@/Services/emitter';

    onMounted(() => {
        emitter.on('notify', (e) => open(e.variant, e.message, e.button));
    });

    onUnmounted(() => {
        emitter.off('notify');
    });

    const open = (variantName, messageText, buttonObject) => {
        if (!variantName || !messageText) return;
        // toast(messageText,{
        //     // title: 'Uh oh! Something went wrong.',
        //     // description: messageText,
        //     class: 'w-full',
        //     variant: variantName === 'error' ? 'destructive' : 'default',
        // });
    };

    // Flash Messages
    const flash = computed(() => usePage().props.jetstream.flash);

    watch(
        flash,
        () => {
            open(flash.value.bannerStyle || 'success', flash.value.banner);
        },
        { immediate: true }
    );
</script>
