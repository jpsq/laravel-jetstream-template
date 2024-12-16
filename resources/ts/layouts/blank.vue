<template>
    <SidebarInset>
        <header class="flex h-16 shrink-0 px-4 items-center gap-2 transition-[width,height] ease-linear z-[99999] border-b">
            <ApplicationLogo class="h-10" />
            <div class="flex-1"></div>
            <ModeToggle class="place-items-end" />
        </header>
        <section class="flex min-h-[calc(100vh_-_theme(spacing.20))] flex-1 flex-col gap-4 md:gap-8">
            <slot />
        </section>
        <Toaster />
    </SidebarInset>
</template>
