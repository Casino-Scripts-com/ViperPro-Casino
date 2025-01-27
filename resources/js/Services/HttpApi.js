import axios from 'axios';
import router from '../Router';
import {useAuthStore} from "@/Stores/Auth.js";

const csrfToken = document.head.querySelector('meta[name="csrf-token"]');

const http_axios = axios.create({
    baseURL: (import.meta.env.VITE_BASE_URL || '/')+'api/',
    headers: {
        'X-CSRF-TOKEN': csrfToken.content,
        "Content-type": "application/json",
        "Access-Control-Allow-Origin": "*",
    },
});

http_axios.interceptors.request.use((request) => {
    const userStore = useAuthStore()

    if(userStore.getToken()) {
        request.headers.Authorization = 'Bearer ' + userStore.getToken()
    }

    return request;
})


http_axios.interceptors.response.use(
    response => response,
    error => {
        if(error.response && [401,403].includes(error.response.status)) {
            //window.location.href = "/";
            router.push('login');
        }
        return Promise.reject(error);
    }
)

export default http_axios;
