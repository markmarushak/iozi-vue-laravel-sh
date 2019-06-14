window.axios = require('axios');


import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueCarousel from 'vue-carousel'
import VueAuth from '@websanova/vue-auth'
import store from './store'

import App from './views/App'
import authParams from './includes/auth'
import routes from './includes/routes'


axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest',
};

Vue.mixin({
    methods: {
        route: route
    }
})

axios.defaults.baseURL = location.origin;

Vue.use(VueRouter)
Vue.use(VueAxios, axios)
Vue.use(VueCarousel)

const router = new VueRouter({
    hashbang: false,
    linkActiveClass: 'active',
    mode: 'history',
    base: __dirname,
    routes: routes
})

Vue.router = router

Vue.use(VueAuth, authParams)

App.loader = {
    load: false,
    text: ''
}


App.router = Vue.router
window.Vue = new Vue({
    store,
    render: h => h(App)
}).$mount('#app')