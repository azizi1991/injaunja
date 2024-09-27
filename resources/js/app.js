import { createApp } from 'vue';
import 'vuetify/styles';
import '@mdi/font/css/materialdesignicons.css';
import 'vuetify/dist/vuetify.min.css';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import 'leaflet/dist/leaflet.css';
import App from './components/Home.vue';
import router from '../../router/index.js';
import axios from 'axios';
import Notifications from '@kyvg/vue3-notification';
import ElementPlus from 'element-plus';
import 'element-plus/dist/index.css'; // مسیر جدید

const vuetify = createVuetify({
    components,
    directives,
    theme: {
        themes: {
            light: {
                primary: '#1976D2',
                secondary: '#424242',
                accent: '#82B1FF',
                error: '#FF5252',
                info: '#2196F3',
                success: '#4CAF50',
                warning: '#FFC107',
            },
        },
    },
    icons: {
        defaultSet: 'mdi',
        aliases: {},
        sets: {},
    },
});

// تنظیمات Axios Interceptor
axios.interceptors.request.use(config => {
    // تنظیم هدرهای پیش‌فرض برای هر درخواست
    config.headers['Accept'] = 'application/json';

    // اضافه کردن توکن اگر در localStorage موجود است
    const token = localStorage.getItem('authToken');
    if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
    }

    return config;
}, error => {
    return Promise.reject(error);
});

// ایجاد برنامه Vue با Vuetify و Router
const app = createApp(App);
app.use(vuetify);
app.use(router);
app.use(Notifications);
app.use(ElementPlus);

app.config.globalProperties.$axios = axios;

// راه‌اندازی برنامه
app.mount('#app');
