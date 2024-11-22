<script setup lang="ts">
    import { computed, useSlots } from 'vue';

    defineEmits(['submitted']);

    const hasActions = computed(() => !!useSlots().actions);
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle><slot name="title" /></CardTitle>
            <CardDescription> <slot name="description" /></CardDescription>
        </CardHeader>
        <form @submit.prevent="$emit('submitted')">
            <CardContent class="grid grid-cols-6 gap-6">
                <slot name="form" />
            </CardContent>
            <CardFooter v-if="hasActions" class="border-t px-6 py-4">
                <slot name="actions" />
            </CardFooter>
        </form>
    </Card>
</template>
