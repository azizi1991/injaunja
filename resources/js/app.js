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
import 'element-plus/dist/index.css';
import DashboardComponent from './components/Dashboard.vue';

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




axios.defaults.baseURL = 'http://127.0.0.1:8001';

axios.interceptors.request.use(config => {
    config.headers['Accept'] = 'application/json';

    const token = localStorage.getItem('authToken');
    if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
    }

    return config;
}, error => {
    return Promise.reject(error);
});

if (document.getElementById('app')) {
    const app = createApp(App);
    app.use(vuetify);
    app.use(router);
    app.use(Notifications);
    app.use(ElementPlus);
    app.config.globalProperties.$axios = axios;

    app.mount('#app');
}

if (document.getElementById('dashboard')) {

    const app = createApp(DashboardComponent);
    app.use(vuetify);
    app.use(router);
    app.use(Notifications);
    app.use(ElementPlus);
    app.component('Dashboardcomponent', DashboardComponent);

    app.config.globalProperties.$axios = axios;

    app.mount('#dashboard');

}
