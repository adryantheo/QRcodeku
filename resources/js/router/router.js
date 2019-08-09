import Vue from 'vue'
import VueRouter from 'vue-router'
import AppQRku from '../components/QRku.vue'

Vue.use(VueRouter)

const routes = [
    {
        path:'/', component: AppQRku,

    }
]

const router = new VueRouter({
    // base: '/P3L-Web/public/',
    routes,
    hashbang: false,
    mode: 'history',
});

export default router;
