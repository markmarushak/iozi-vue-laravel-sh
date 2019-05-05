import Home from '../views/Home'
import Cabinet from '../views/Cabinet.vue'
import Products from '../views/Products.vue'
import Payment from '../views/Payment.vue'
import Setting from '../views/Setting.vue'
import Rent from '../views/Rent.vue'
import ProductSettings from '../views/ProductSettings.vue'
import Tariff from '../views/Tariff.vue'
import Attribute from '../views/productSetting/Attribute.vue'
import Option from '../views/productSetting/Option.vue'


import Dashboard from '../components/Dashboard.vue'
import Register from '../components/Register.vue'
import Login from '../components/Login.vue'

let routes = [{
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
        },
        children: [
            { path: '/products', name: 'products', component: Products },
            { path: '/payment', name: 'payment', component: Payment },
            { path: '/rent', name: 'rent', component: Rent },
            { path: '/tariff', name: 'tariff', component: Tariff },
            { 
                path: '/product-settings', 
                name: 'product-settings', 
                component:  ProductSettings,
                children: [
                    { path: '/attribute', name: 'attribute', component: Attribute },
                    { path: '/option', name: 'option', component: Option },
                ]
            },
            { path: '/setting', name: 'setting', component: Setting }
        ]
    }];

    export default routes