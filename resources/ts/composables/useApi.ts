import { createFetch } from '@vueuse/core';
import { destr } from 'destr';
import nProgress from 'nprogress';

export const useApi = createFetch({
    baseUrl: import.meta.env.VITE_API_BASE_URL || '/api',
    fetchOptions: {
        headers: {
            Accept: 'application/json',
        },
    },
    options: {
        refetch: true,

        async beforeFetch({ options }) {
            nProgress.start()
            return { options };
        },
        afterFetch(ctx) {
            nProgress.done();
            const { data, response } = ctx;

            // Parse data if it's JSON

            let parsedData = null;
            try {
                parsedData = destr(data);
            } catch (error) {
                console.error(error);
            }

            return { data: parsedData, response };
        },
        onFetchError(ctx) {
            nProgress.done();
            return ctx;
        },
    },
});
