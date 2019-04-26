
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



// require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueCarousel from 'vue-carousel';



import App from './views/App'
import Home from './views/Home'
import Cabinet from './views/Cabinet.vue'


import Dashboard from './components/Dashboard.vue'
import Register from './components/Register.vue'
import Login from './components/Login.vue'

Vue.use(VueRouter)
Vue.use(VueAxios, axios)
Vue.use(VueCarousel)


axios.defaults.baseURL = 'http://learn.home/api';

const router = new VueRouter({
    hashbang: false,
    linkActiveClass: 'active',
    mode: 'history',
    base: __dirname,
    routes: [{
        path: '/',
        name: 'home',
        component: Home
    },{
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            auth: false
        }
    },{
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        },
    },{
        path: '/cabinet',
        name: 'cabinet',
        component: Cabinet,
        meta: {
            auth: true
        } // Meta Field , you can name it 
    }]
});

Vue.router = router
Vue.use(require('@websanova/vue-auth'), {
    rolesVar: 'role',
    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

App.router = Vue.router
new Vue(App).$mount('#app');

// const app = new Vue({
// 	el: '#app',
// 	components: { App },
// 	router: router
// })
