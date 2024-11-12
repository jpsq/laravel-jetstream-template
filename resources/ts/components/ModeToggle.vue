<script setup lang="ts">
    import { useColorMode } from '@vueuse/core';

    // Pass { disableTransition: false } to enable transitions
    const mode = useColorMode();
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" size="icon" class="rounded-full">
                <Icon name="tabler-moon" v-if="mode === 'light'" class="rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0" />
                <Icon name="tabler-sun" v-else class="absolute rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100" />
                <span class="sr-only">Toggle theme</span>
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="start">
            <DropdownMenuItem @click="mode = 'light'"> Light </DropdownMenuItem>
            <DropdownMenuItem @click="mode = 'dark'"> Dark </DropdownMenuItem>
            <DropdownMenuItem @click="mode = 'auto'"> System </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
