import { createRouter, createWebHistory } from "vue-router";
import Home from '../pages/Home.vue';
import Login from '../pages/auth/Login.vue';
import Reset from '../pages/auth/Reset.vue';
import Create from '../pages/poll/Create.vue';
import Show from '../pages/poll/Show.vue';
import Profil from '../pages/auth/Profil.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
    },
    {
        path: '/reset-password',
        name: 'reser_password',
        component: Reset,
    },
    {
        path: '/create-poll',
        name: 'create_poll',
        component: Create,
    },
    {
        path: '/poll/:id',
        name: 'show',
        component: Show,
    },
    {
        path: '/profil',
        name: 'profil',
        component: Profil,
    },
];

export default createRouter({
    history: createWebHistory(),
    routes
});