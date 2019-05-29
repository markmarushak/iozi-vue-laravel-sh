import {Ziggy} from './ziggy'

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
    user_role: '',
    parseUserData: function (data) {
       axios.get(route('get.user')).then(res => {
           this.user_role = res.data.data.roleLevel
           this.user_id = res.data.data.id
           this.name = res.data.data.name
       })
    }
}