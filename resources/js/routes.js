import Vue from 'vue';
import VueRouter from 'vue-router';

import Tonghop from './pages/Tonghop';
import Banhang from './pages/Banhang';
import Chungtubanhang from './pages/banhang/Chungtubanhang';
import Muahang from './pages/Muahang';

Vue.use(VueRouter);

export const router = new VueRouter({
    mode: 'history',
    routes: [{
            path: '/',
            name: 'Index',
            component: Tonghop,
        },
        {
            path: '/tonghop',
            name: 'Tong hop',
            component: Tonghop,
        },
        {
            path: '/banhang',
            name: 'Ban hang',
            component: Banhang,
            children: [{
                path: 'chungtu',
                name: 'Hoa don ban hang',
                component: Chungtubanhang
            }, ]

        },
        {
            path: '/muahang',
            name: 'Mua hang',
            component: Muahang,
        },
    ],
});
