/*
 |-------------------------------------------------------------------------------
 | routes.js
 |-------------------------------------------------------------------------------
 | Contains all of the routes for the application
 */

/**
 * Imports Vue and VueRouter to extend with the routes.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store.js'

/**
 * Extends Vue to use Vue Router
 */
Vue.use(VueRouter);

/**
 * beforeEnter执行的方法，传入to, from, next三个参数
 * @param {string} to
 * @param {string} from
 * @param {function} next
 */
function requireAuth(to, from, next) {
    function proceed() {
        // 如果用户信息已经加载，并且不为空则说明该用户已经登陆，可以继续访问路由，否则跳转到首页
        // 这个功能类似Laravel中auth中间件
        if (store.getters.getUserLoadStatus() !== 2) {
            return;
        }

        if (store.getters.getUser !== '') {
            next();
        } else {
            next('/home');
        }
    }

    if (store.getters.getUserLoadStatus() !== 2) {
        // 如果用户信息未加载完毕则加载
        store.dispatch('loadUser');

        // 监听用户信息加载状态，加载完成后调用proceed 方法继续操作
        // 第一个参数为函数，不加()
        store.watch(store.getters.getUserLoadStatus, function () {
            if (store.getters.getUserLoadStatus() === 2) {
                proceed();
            }
        });
    } else {
        // 如果用户信息加载完毕，直接调用proceed方法
        proceed();
    }
}

export default new VueRouter({
    routes: [
        {
            path: '/',
            redirect: {name: 'home'},
            name: 'layout',
            component: Vue.component('Home', require('./pages/Layout.vue')),
            children: [
                {
                    path: 'home',
                    name: 'home',
                    component: Vue.component('Home', require('./pages/Home.vue'))
                },
                {
                    path: 'cafes',
                    name: 'cafes',
                    component: Vue.component('Cafes', require('./pages/Cafes.vue'))
                },
                {
                    path: 'cafes/new',
                    name: 'newcafe',
                    component: Vue.component('NewCafe', require('./pages/NewCafe.vue')),
                    beforeEnter:requireAuth
                },
                {
                    path: 'cafes/:id',
                    name: 'cafe',
                    component: Vue.component('Cafe', require('./pages/Cafe.vue'))
                }
            ]
        }

    ]
});