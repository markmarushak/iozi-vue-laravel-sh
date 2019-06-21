import {Ziggy} from './ziggy'
import axios from 'axios'
import store from '../store/index'
window.Ziggy  = Ziggy;
window.route = require('../../../vendor/tightenco/ziggy/dist/js/route');

export default {
    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
    rolesVar:           'permissionList',
    loginData:          { url: route('login').url() },
    logoutData:         { url: route('logout').url() },
    registerData:       { url: route('register').url() },
    refreshData:        { enabled: false },
    parseUserData: function () {
        axios.get(route('get.user')).then(response => {
            store.commit('set', {type: 'user', items: response.data.data})

        })
    }
}