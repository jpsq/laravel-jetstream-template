<script lang="ts" setup>
    import { Label } from '@/core/components/label';
    import { useFormField } from './useFormField';

    const { formItemId } = useFormField();
</script>

<template>
    <Label :for="formItemId">
        <slot />
    </Label>
</template>
