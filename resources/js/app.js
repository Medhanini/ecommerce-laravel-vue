require('./bootstrap');
const app = new Vue({
    el: '#app',
    components: { App },
    router,
});

import Vue from 'vue'
    import VueRouter from 'vue-router'

    Vue.use(VueRouter)

    import App from './views/App'
    import Home from './views/components/Home'
    import Login from './views/components/Login'
    import Register from './views/components/Register'
    import SingleProduct from './views/components/SingleProduct'
    import Checkout from './views/components/Checkout'
    import Confirmation from './views/components/Confirmation'
    import UserBoard from './views/components/UserBoard'
    import Admin from './views/components/Admin'

    const router = new VueRouter({
        mode: 'history',
        routes: [
            {
                path: '/',
                name: 'home',
                component: Home
            },
            {
                path: '/login',
                name: 'login',
                component: Login
            },
            {
                path: '/register',
                name: 'register',
                component: Register
            },
            {
                path: '/products/:id',
                name: 'single-products',
                component: SingleProduct
            },
            {
                path: '/confirmation',
                name: 'confirmation',
                component: Confirmation
            },
            {
                path: '/checkout',
                name: 'checkout',
                component: Checkout,
                props: (route) => ({ pid: route.query.pid })
            },
            {
                path: '/dashboard',
                name: 'userboard',
                component: UserBoard,
                meta: {
                    requiresAuth: true,
                    is_user: true
                }
            },
            {
                path: '/admin/:page',
                name: 'admin-pages',
                component: Admin,
                meta: {
                    requiresAuth: true,
                    is_admin: true
                }
            },
            {
                path: '/admin',
                name: 'admin',
                component: Admin,
                meta: {
                    requiresAuth: true,
                    is_admin: true
                }
            },
        ],
    })

    router.beforeEach((to, from, next) => {
        if (to.matched.some(record => record.meta.requiresAuth)) {
            if (localStorage.getItem('bigStore.jwt') == null) {
                next({
                    path: '/login',
                    params: { nextUrl: to.fullPath }
                })
            } else {
                let user = JSON.parse(localStorage.getItem('bigStore.user'))
                if (to.matched.some(record => record.meta.is_admin)) {
                    if (user.is_admin == 1) {
                        next()
                    }
                    else {
                        next({ name: 'userboard' })
                    }
                }
                else if (to.matched.some(record => record.meta.is_user)) {
                    if (user.is_admin == 0) {
                        next()
                    }
                    else {
                        next({ name: 'admin' })
                    }
                }
                next()
            }
        } else {
            next()
        }
    })