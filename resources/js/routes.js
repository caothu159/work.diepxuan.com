import Vue from 'vue';
import VueRouter from 'vue-router';

import Tonghop from './pages/Tonghop';
import Banhang from './pages/Banhang';
import Chungtubanhang from './pages/banhang/Chungtubanhang';
import Chungtubanhangvt from './pages/banhang/Chungtubanhangvt';
import Muahang from './pages/Muahang';

Vue.use(VueRouter);

const router = new VueRouter({
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
                component: Chungtubanhang,
                children: [{
                    path: ':id',
                    name: 'Hoa don ban hang chi tiet',
                    component: Chungtubanhangvt
                }, ]
            }, ]

        },
        {
            path: '/muahang',
            name: 'Mua hang',
            component: Muahang,
        },
    ],
});

router.beforeEach((to, from, next) => {
    // console.log(isAuthenticated);
    // console.log(from);
    if (to.name !== 'Login' && !isAuthenticated)
        next()
    // next({ name: 'Login' })
    else
        next()
})


export { router };
