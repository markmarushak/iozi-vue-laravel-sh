import {Ziggy} from './ziggy'
import axios from 'axios'
import store from '../store/index'
window.Ziggy  = Ziggy;
window.route = require('../../../vendor/tightenco/ziggy/dist/js/route');

export default {
    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
    loginData:          { url: route('auth.login').url() },
    logoutData:         { url: route('auth.logout').url() },
    registerData:       { url: route('auth.register').url() },
    refreshData:        { url: route('auth.refresh').url() },
}