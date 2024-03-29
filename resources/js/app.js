/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
// import datepicker from 'vuejs-datepicker';

import { Form, HasError, AlertError } from 'vform';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('salary-component', require('./components/SalaryComponent.vue').default);
Vue.component('salary', require('./components/SalaryComponent.vue').default);
Vue.component('salaryitem', require('./components/SalaryitemComponent.vue').default);
Vue.component('salaryuser', require('./components/SalaryuseritemComponent.vue').default);
// Vue.component('datepicker', datepicker);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
