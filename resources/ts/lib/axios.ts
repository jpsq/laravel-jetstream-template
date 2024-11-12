import _axios from 'axios';
// window.axios = axios;

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const axios = _axios.create({
    baseURL: window.location.origin,
    headers: {
        common: {
            'X-Requested-With': 'XMLHttpRequest',
        },
    },
});
axios.defaults.withCredentials = true;
(window as any).axios = axios;
export default axios;
