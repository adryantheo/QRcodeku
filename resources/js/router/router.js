import Vue from 'vue'
import VueRouter from 'vue-router'
import AppQRku from '../components/QRku.vue'
import Admin from '../components/Admin/AdminLanding.vue'

Vue.use(VueRouter)

const routes = [
    {
        path:'/', component: AppQRku,
        
    },
    {
        path:'/admin', component: Admin,
    }
]

const router = new VueRouter({
    routes,
    hashbang: false,
    mode: 'history',
});

export default router;
