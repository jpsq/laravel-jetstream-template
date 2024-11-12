<script setup lang="ts">
    import SectionTitle from './SectionTitle.vue';
    const hasActions = computed(() => !!useSlots().actions);
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle><slot name="title" /></CardTitle>
            <CardDescription> <slot name="description" /></CardDescription>
        </CardHeader>
        <CardContent>
            <slot name="content" />
        </CardContent>
        <CardFooter v-if="hasActions" class="border-t px-6 py-4">
            <slot name="actions" />
        </CardFooter>
    </Card>
</template>
