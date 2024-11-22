<script setup lang="ts">
    import { ref } from 'vue';
    import { Link } from '@inertiajs/vue3';
    import { Team } from '@/types';
    import { mobileNavItems, navSections } from '@/navigation';
    import Toaster from '@/core/components/toast/Toaster.vue';
    import { Toaster as Sonner } from '@/core/components/sonner';

    const page = usePage();

    const activeTeam = ref<Team>(page.props.auth.user?.current_team);

    function setActiveTeam(team: Team) {
        router.put(route('current-team.update'), { team_id: team.id }, { preserveState: false, onSuccess: () => (activeTeam.value = team) });
    }

    const logout = () => {
        router.post(route('logout'));
    };

    const flash = computed(() => usePage().props.jetstream.flash);

    watch(
        flash,
        ({ bannerStyle, banner }) => {
            if (!banner) return;
            setTimeout(() => {
                switch (bannerStyle) {
                    case 'success':
                        sonnerSuccess(banner);
                        break;
                    case 'danger':
                        sonnerError(banner);
                        break;
                    case 'warning':
                        sonnerWarning(banner);
                        break;
                    case 'info':
                        sonnerInfo(banner);
                        break;
                    default:
                        sonnerToast(banner);
                        break;
                }
            }, 1000);
        },
        { immediate: true }
    );
</script>

<template>
    <SidebarProvider v-slot="{ isMobile }">
        <Sidebar collapsible="icon" variant="sidebar" v-slot="{ open }">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <!-- Teams Dropdown -->
                        <DropdownMenu v-if="$page.props.jetstream.hasTeamFeatures && $page.props.auth.user">
                            <DropdownMenuTrigger as-child>
                                <SidebarMenuButton
                                    size="lg"
                                    class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
                                >
                                    <div
                                        class="flex aspect-square size-8 items-center justify-center rounded-lg overflow-hidden bg-sidebar-primary text-sidebar-primary-foreground"
                                    >
                                        <Icon name="tabler-users" class="h-full w-full bg-muted" />
                                    </div>
                                    <div class="grid flex-1 text-left text-sm leading-tight" v-if="open">
                                        <span class="truncate font-semibold">{{ activeTeam?.name || '' }}</span>
                                        <!-- <span class="truncate text-xs">{{ activeTeam.bio }}</span> -->
                                    </div>
                                    <Icon name="tabler-caret-up-down" class="ml-auto" v-if="open" />
                                </SidebarMenuButton>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent
                                class="w-[--radix-dropdown-menu-trigger-width] min-w-56 rounded-lg"
                                align="start"
                                side="bottom"
                                :side-offset="4"
                            >
                                <DropdownMenuLabel class="text-xs text-muted-foreground"> Teams </DropdownMenuLabel>
                                <DropdownMenuItem
                                    v-for="(team, index) in $page.props.auth.user.all_teams"
                                    :key="team.name"
                                    :class="['gap-2 p-2', { 'bg-accent text-accent-foreground': team.id === activeTeam?.id }]"
                                    @click="setActiveTeam(team)"
                                >
                                    <div class="flex size-6 items-center justify-center rounded-full overflow-hidden border">
                                        <img v-if="team.avatar" :src="'/storage/' + team.avatar" class="h-full w-full" />
                                        <Icon v-else name="tabler-users" class="h-full w-full bg-muted" />
                                    </div>
                                    {{ team.name }}
                                    <DropdownMenuShortcut>⌘{{ index + 1 }}</DropdownMenuShortcut>
                                </DropdownMenuItem>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem
                                    class="gap-2 p-2"
                                    v-if="$page.props.jetstream.canCreateTeams"
                                    :as="Link"
                                    :href="route('teams.create')"
                                >
                                    <div class="flex size-6 items-center justify-center rounded-md border bg-background">
                                        <Icon name="tabler-plus" />
                                    </div>
                                    <div class="font-medium text-muted-foreground">Add team</div>
                                </DropdownMenuItem>
                                <DropdownMenuItem
                                    v-if="$page.props.auth.user.current_team_id"
                                    class="gap-2 p-2"
                                    :as="Link"
                                    :href="route('teams.show', $page.props.auth.user.current_team_id)"
                                >
                                    <div class="flex size-6 items-center justify-center rounded-md border bg-background">
                                        <Icon name="tabler-settings" />
                                    </div>
                                    <div class="font-medium text-muted-foreground">Team Settings</div>
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>
            <SidebarContent>
                <SidebarGroup v-for="sections in navSections" :key="sections.heading">
                    <SidebarGroupLabel>{{ sections.heading }}</SidebarGroupLabel>
                    <SidebarMenu>
                        <template v-for="item in sections.navItems">
                            <!-- @vue-expect-error -->
                            <template v-if="item?.children">
                                <Collapsible as-child class="group/collapsible">
                                    <SidebarMenuItem>
                                        <CollapsibleTrigger as-child>
                                            <SidebarMenuButton :tooltip="item.title">
                                                <Icon :name="item.icon" class="!shrink-0" />
                                                <span>{{ item.title }}</span>
                                                <Icon
                                                    name="tabler-chevron-right"
                                                    class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90"
                                                />
                                            </SidebarMenuButton>
                                        </CollapsibleTrigger>
                                        <CollapsibleContent>
                                            <SidebarMenuSub>
                                                <!-- @vue-expect-error -->
                                                <SidebarMenuSubItem v-for="subItem in item.children" :key="subItem.title">
                                                    <SidebarMenuSubButton as-child>
                                                        <Link :href="route(subItem.route)">{{ subItem.title }}</Link>
                                                    </SidebarMenuSubButton>
                                                </SidebarMenuSubItem>
                                            </SidebarMenuSub>
                                        </CollapsibleContent>
                                    </SidebarMenuItem>
                                </Collapsible>
                            </template>
                            <SidebarMenuItem v-else>
                                <SidebarMenuButton :tooltip="item.title" :variant="route().current(item.route) ? 'active' : 'default'">
                                    <Icon :name="item.icon" class="!shrink-0" />
                                    <Link :href="route(item.route)">{{ item.title }}</Link>
                                </SidebarMenuButton>
                            </SidebarMenuItem>
                        </template>
                    </SidebarMenu>
                </SidebarGroup>
            </SidebarContent>
            <SidebarFooter>
                <SidebarMenu>
                    <SidebarMenuItem v-if="$page.props.auth.user">
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <SidebarMenuButton
                                    size="lg"
                                    class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
                                >
                                    <Avatar class="h-8 w-8 border">
                                        <AvatarImage :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name" />
                                    </Avatar>
                                    <div class="grid flex-1 text-left text-sm leading-tight">
                                        <span class="truncate font-semibold">{{ $page.props.auth.user.name }}</span>
                                        <span class="truncate text-xs">{{ $page.props.auth.user.email }}</span>
                                    </div>
                                    <Icon name="tabler-caret-up-down" class="ml-auto size-4" />
                                </SidebarMenuButton>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent
                                class="w-[--radix-dropdown-menu-trigger-width] min-w-56 rounded-lg"
                                side="bottom"
                                align="end"
                                :side-offset="4"
                            >
                                <DropdownMenuLabel class="p-0 font-normal">
                                    <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                        <Avatar class="h-8 w-8 border">
                                            <AvatarImage :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name" />
                                            <AvatarFallback class="rounded-lg">{{ $page.props.auth.user.name[0] }}</AvatarFallback>
                                        </Avatar>
                                        <div class="grid flex-1 text-left text-sm leading-tight">
                                            <span class="truncate font-semibold">{{ $page.props.auth.user.name }}</span>
                                            <span class="truncate text-xs">{{ $page.props.auth.user.email }}</span>
                                        </div>
                                    </div>
                                </DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <DropdownMenuGroup>
                                    <DropdownMenuItem>
                                        <Icon name="tabler-sparkles" />
                                        Upgrade to Pro
                                    </DropdownMenuItem>
                                </DropdownMenuGroup>
                                <DropdownMenuSeparator />
                                <DropdownMenuGroup>
                                    <DropdownMenuItem :as="Link" :href="route('profile.show')">
                                        <Icon name="tabler-user" />
                                        Profile
                                    </DropdownMenuItem>
                                    <DropdownMenuItem :as="Link" v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                        <Icon name="tabler-key" />
                                        API Tokens
                                    </DropdownMenuItem>
                                    <DropdownMenuItem :as="Link" :href="route('services.index')">
                                        <Icon name="tabler-puzzle" />
                                        services
                                    </DropdownMenuItem>
                                </DropdownMenuGroup>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem @click="logout">
                                    <Icon name="tabler-logout" />
                                    Log out
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </SidebarMenuItem>
                    <template v-else>
                        <SidebarMenuItem>
                            <SidebarMenuButton tooltip="Login" :as="Link" :href="route('login')">
                                <Icon name="tabler-login" />
                                <span>Login</span>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                        <SidebarMenuItem>
                            <SidebarMenuButton tooltip="Login with Google">
                                <Icon name="tabler-brand-google" />
                                <span>Login with Google</span>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                        <SidebarMenuItem>
                            <SidebarMenuButton tooltip="Create Account" :as="Link" :href="route('register')">
                                <Icon name="tabler-user-plus" />
                                <span>Create Account</span>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    </template>
                </SidebarMenu>
            </SidebarFooter>
            <SidebarRail />
        </Sidebar>

        <SidebarInset class="bg-background" :is-mobile="isMobile">
            <Sonner />
            <header class="flex h-16 shrink-0 px-4 items-center gap-2 transition-[width,height] ease-linear z-[99999]">
                <div class="flex items-center gap-2 w-100">
                    <SidebarTrigger class="-ml-1" />
                    <Separator orientation="vertical" class="mr-2 h-4" />
                    <Breadcrumb>
                        <BreadcrumbList>
                            <template v-for="(item, index) in $page.props.breadcrumbs" :key="item.title">
                                <BreadcrumbSeparator class="hidden md:block" v-if="index > 0" />
                                <BreadcrumbItem class="hidden md:block">
                                    <!-- @vue-skip -->

                                    <BreadcrumbLink v-if="item.url" :as="Link" :href="item.url">
                                        <Icon v-if="item?.type === 'icon'" :name="item.title" />
                                        <span v-else>
                                            {{ item.title }}
                                        </span>
                                    </BreadcrumbLink>
                                    <BreadcrumbPage v-else>
                                        <Icon v-if="item?.type === 'icon'" :name="item.title" />
                                        <span v-else>
                                            {{ item.title }}
                                        </span>
                                    </BreadcrumbPage>
                                </BreadcrumbItem>
                            </template>
                        </BreadcrumbList>
                    </Breadcrumb>
                </div>
                <div class="flex-1"></div>
                <ApplicationLogo class="h-10" />
                <div class="flex-1"></div>
                <ModeToggle class="place-items-end" />
            </header>
            <Suspense>
                <section class="flex min-h-[calc(100vh_-_theme(spacing.20))] flex-1 flex-col gap-4 p-4 md:gap-8 md:p-10 container">
                    <slot />
                </section>
            </Suspense>
            <div v-if="isMobile" class="h-16 bg-surface border-t border-border px-4 fixed bottom-0 w-full z-[9999]">
                <nav class="h-full max-w-lg mx-auto">
                    <ul class="h-full flex items-center justify-around">
                        <li v-for="item in mobileNavItems" :key="item.title" class="h-full">
                            <Link
                                class="h-full w-16 flex flex-col items-center justify-center gap-1 text-xs transition-all duration-200 relative"
                                :class="[
                                    route().current(item.route)
                                        ? 'text-primary active:animate-bounce'
                                        : 'text-muted-foreground hover:text-primary/50',
                                ]"
                                :href="route(item.route)"
                            >
                                <Icon :name="item.icon" class="h-5 w-5" />
                                <span>{{ item.title }}</span>
                                <span
                                    v-if="route().current(item.route)"
                                    class="absolute -top-0.5 left-1/2 -translate-x-1/2 h-0.5 w-8 bg-primary rounded-full transition-all duration-300"
                                />
                            </Link>
                        </li>
                    </ul>
                </nav>
            </div>
        </SidebarInset>
    </SidebarProvider>
</template>
