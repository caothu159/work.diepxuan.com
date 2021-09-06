/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue').default;

import { Form, HasError, AlertError } from 'vform';

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import App from './pages/App';
import { router } from './routes';

Vue.config.productionTip = false;
Vue.config.devtools = false;
Vue.config.silent = true;

const app = new Vue({
    el: '#app',
    router,
    render: (h) => h(App),
});
