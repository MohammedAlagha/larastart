require('./bootstrap');


window._ = require('lodash');

window.Vue = require('vue');

import moment from 'moment';

import { Form, HasError, AlertError } from 'vform'

window.Form = Form;


import VueRouter from 'vue-router'

Vue.use(VueRouter)


import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '2px'
})

import gate from "./gate"

Vue.prototype.$gate = new gate(user);     //bring window.user from app/master line 168




import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', swal.stopTimer)
        toast.addEventListener('mouseleave', swal.resumeTimer)
    }
})

window.toast = toast;

window.Fire = new Vue;



let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default },
]

const router = new VueRouter({
    mode: 'history',
    routes
})



Vue.filter('upText', (text) => {
    return text.charAt(0).toUpperCase() + text.slice(1);
})

Vue.filter('myDate', (created) => {
    return moment(created).format("MMMM Do YYYY")
})



Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'not-found',
    require('./components/NotFound.vue').default
);


Vue.component('pagination', require('laravel-vue-pagination'));


const app = new Vue({
    el: '#app',
    router,
    data:{
        search: ""
    },
    methods:{
        searchit:_.debounce(()=>{
            Fire.$emit('searching');
        },1000)
    }
}).$mount('#app');
