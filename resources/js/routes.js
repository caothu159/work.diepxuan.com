import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './pages/Home';
import User from './pages/User';

Vue.use(VueRouter);

export const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'Index',
            component: Home,
        },
        {
            path: '/index.html',
            name: 'Home',
            component: Home,
        },
        {
            path: '/users/:userId',
            name: 'User',
            component: User,
        },
    ],
});
