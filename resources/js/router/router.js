import Vue from 'vue'
import VueRouter from 'vue-router'
import AppQRku from '../components/QRku.vue'
import Admin from '../components/Admin/AdminLanding.vue'
import AdminCredit from '../components/Admin/AdminCredit.vue'

Vue.use(VueRouter)

const routes = [
    {
        path:'/', component: AppQRku,
        
    },
    {
        path:'/admin', component: Admin,
        children: [
            {path: '/brand/:brand', component: AdminCredit, props:true}
        ]
    }
]

const router = new VueRouter({
    routes,
    hashbang: false,
    mode: 'history',
});

export default router;
