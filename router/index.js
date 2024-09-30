import { createRouter, createWebHistory } from 'vue-router';
import Home from '../resources/js/components/Home.vue';
import Dashboardcomponent from '../resources/js/components/Dashboard.vue';
import LoginModal from '../resources/js/components/LoginModal.vue';



const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboardcomponent,
    },
    {
        path: '/login',
        name: 'Login',
        component: LoginModal,
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

