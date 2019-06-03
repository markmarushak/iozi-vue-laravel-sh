import Home from '../views/Home'
import Cabinet from '../views/Cabinet'
import Products from '../views/Products'
import Check from '../views/Products/Check'
import Payment from '../views/Payment'
import Setting from '../views/Setting'
import Rent from '../views/Rent'
import ProductSettings from '../views/ProductSetting'
import Tariff from '../views/Tariff'

import Attribute from '../views/productSetting/Attribute'
import Option from '../views/productSetting/Option'
import Time from '../views/productSetting/Time'
import Image from '../views/productSetting/Image'


import Register from '../components/Register'
import Login from '../components/Login'

let routes = [{
        path: '/',
        name: 'home',
        component: Home,
    },
    {
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
        }
    },{
        path: '/cabinet',
        name: 'cabinet',
        component: Cabinet,
        meta: {
            auth: true
        },
        children: [
            { path: 'products', name: 'products', component: Products },
            { path: 'products-check', name: 'products-check', component: Check },
            { path: 'payment', name: 'payment', component: Payment },
            { path: 'rent', name: 'rent', component: Rent },
            { path: 'tariff', name: 'tariff', component: Tariff },
            {
                path: 'product-settings',
                name: 'product-settings', 
                component:  ProductSettings,
                children: [
                    { path: 'attribute', name: 'attribute', component: Attribute },
                    { path: 'option', name: 'option', component: Option },
                    { path: 'time', name: 'time', component: Time },
                    { path: 'image', name: 'image', component: Image },
                ]
            },
            { path: '/setting', name: 'setting', component: Setting }
        ]
    }];

    export default routes