<script setup lang="ts">
    type MediaFileProps = {
        media: {
            id: number;
            thumb_url: string;
            name: string;
            is_video: boolean;
            error?: string;
        };
        imgHeight?: 'full' | 'sm';
        imgWidthFull?: boolean;
    };

    const props = defineProps<MediaFileProps>();

    const imgHeightClass = computed(() => {
        return {
            full: 'h-full',
            sm: 'h-20',
        }[props.imgHeight || 'full'];
    });

    const playlists = ['Focus'];
</script>

<template>
    <div>
        <ContextMenu>
            <ContextMenuTrigger>
                <figure class="relative">
                    <slot />
                    <div class="relative flex rounded" :class="{ 'border border-red-500 p-5': media.hasOwnProperty('error') }">
                        <span v-if="media.is_video" class="absolute top-0 right-0 mt-1 mr-1">
                            <Icon name="tabler-video" class="!w-4 !h-4 text-white" />
                        </span>

                        <div v-if="media.hasOwnProperty('error')" class="text-center">
                            <Icon name="tabler-exclamation-mark" class="w-8 h-8 mx-auto text-red-500" />
                            <div class="mt-xs">{{ media.name }}</div>
                            <div class="mt-xs text-red-500">{{ media.error ? media.error : $t('media.error_uploading_media') }}</div>
                        </div>

                        <img
                            :src="media.thumb_url"
                            loading="lazy"
                            alt="Image"
                            class="rounded-md"
                            :class="[imgHeightClass, { 'w-full': imgWidthFull }]"
                        />
                    </div>
                </figure>
            </ContextMenuTrigger>
            <ContextMenuContent class="w-40">
                <ContextMenuItem>Add to Library</ContextMenuItem>
                <ContextMenuSub>
                    <ContextMenuSubTrigger>Add to Playlist</ContextMenuSubTrigger>
                    <ContextMenuSubContent class="w-48">
                        <ContextMenuItem>
                            <Icon name="tabler-playlist-add" class="mr-2 h-4 w-4" />
                            New Playlist
                        </ContextMenuItem>
                        <ContextMenuSeparator />
                        <ContextMenuItem v-for="playlist in playlists" :key="playlist">
                            <Icon name="tabler-playlist" class="mr-2 h-4 w-4" />
                            {{ playlist }}
                        </ContextMenuItem>
                    </ContextMenuSubContent>
                </ContextMenuSub>
                <ContextMenuSeparator />
                <ContextMenuItem>Play Next</ContextMenuItem>
                <ContextMenuItem>Play Later</ContextMenuItem>
                <ContextMenuItem>Create Station</ContextMenuItem>
                <ContextMenuSeparator />
                <ContextMenuItem>Like</ContextMenuItem>
                <ContextMenuItem>Share</ContextMenuItem>
            </ContextMenuContent>
        </ContextMenu>
        <!-- <div class="space-y-1 text-sm">
            <h3 class="font-medium leading-none">
                {{ media.name }}
            </h3>
            <p class="text-xs text-muted-foreground">
                {{ media.id }}
            </p>
        </div> -->
    </div>
</template>
