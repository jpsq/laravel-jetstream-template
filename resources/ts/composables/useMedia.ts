import NProgress from 'nprogress';
import { debounce } from 'lodash';

import { Media } from '@/types';

const useMedia = (routeName = 'media.fetchUploads', routeParams = {}) => {

    const activeTab = ref('uploads');

    const tabs = computed(() => {
        return {
            uploads: 'Upload',
            stock: 'Stock Photos',
            gifs: 'GIFs',
        };
    });

    const isLoaded = ref(false);
    const isDownloading = ref(false);
    const isDeleting = ref(false);
    const page = ref(1);
    const items = ref<Media[]>([]);
    const isFetching = ref(false);
    const errors = ref<Record<string, string[]>>({});
    const endlessPagination = ref<HTMLElement | null>(null);
    const keyword = ref('');

    const selected = ref<Media[]>([]);
    const toggleSelect = (media: Media) => {
        const index = selected.value.findIndex((item) => item.id === media.id);

        if (index < 0 && !media.hasOwnProperty('error')) {
            selected.value.push(media);
        }

        if (index >= 0) {
            selected.value.splice(index, 1);
        }
    };

    const deselectAll = () => {
        selected.value = [];
    };

    const isSelected = (media: Media) => {
        const index = selected.value.findIndex((item) => item.id === media.id);

        return index !== -1;
    };

    const fetchItems = (appendResult = true) => {
        if (!page.value) {
            return;
        }
        NProgress.start();
        isFetching.value = true;
        axios
            .get(route(routeName, routeParams), {
                params: {
                    page: page.value,
                    keyword: keyword.value,
                },
            })
            .then(function (response: any) {
                const nextLink = response.data.links.next;

                if (nextLink) {
                    page.value = response.data.links.next.split('?page=')[1];
                }

                if (!nextLink) {
                    page.value = 0;
                }

                if (!appendResult) {
                    items.value = response.data.data;
                }

                if (appendResult) {
                    items.value = [...items.value, ...response.data.data];
                }
            })
            .catch((e) => {
                pauseObserver();
                sonnerError( 'Error retrieving media. Try again!');
            })
            .finally(() => {
                NProgress.done();
                isLoaded.value = true;
                isFetching.value = false;
            });
    };

    const downloadExternal = (items: any[], callback: Function) => {
        isDownloading.value = true;
        NProgress.start();

        axios
            .post(route('media.download', routeParams), {
                items,
                from: activeTab.value,
            })
            .then((response) => {
                callback(response);
            })
            .catch(() => {
                sonnerError( 'Error downloading media. Try again!');
            })
            .finally(() => {
                isDownloading.value = false;
                NProgress.done();
                NProgress.remove();
            });
    };

    const removeItems = (ids: number[]) => {
        items.value = items.value.filter((item) => !ids.includes(item.id));
    };

    const deletePermanently = (items: number[], callback: Function) => {
        isDeleting.value = true;
        NProgress.start();

        axios
            .delete(route('media.delete', routeParams), {
                data: {
                    items,
                },
            })
            .then(() => {
                callback();
            })
            .catch(() => {
                sonnerError( 'Error deleting media. Try again!');
            })
            .finally(() => {
                isDeleting.value = false;
                NProgress.done();
                NProgress.remove();
            });
    };

    const {
        resume: createObserver,
        stop: destroyObserver,
        pause: pauseObserver,
    } = useIntersectionObserver(
        endlessPagination,
        ([{ isIntersecting }], observerElement) => {
            if (isIntersecting) {
                fetchItems();
            }
        },
        { immediate: false }
    );

    watch(
        keyword,
        debounce(() => {
            page.value = 1;
            fetchItems(false);
        }, 300)
    );

    return {
        activeTab,
        tabs,
        isLoaded,
        isDownloading,
        isDeleting,
        keyword,
        page,
        items,
        isFetching,
        endlessPagination,
        selected,
        downloadExternal,
        deletePermanently,
        removeItems,
        createObserver,
        toggleSelect,
        deselectAll,
        isSelected,
    };
};

export default useMedia;
