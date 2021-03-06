import Vue from 'vue'
import VueRouter from 'vue-router'
import AppQRku from '../components/QRku.vue'
import Admin from '../components/Admin/AdminLanding.vue'
import detailBrand from '../components/Admin/detailBrand.vue'
import AdminBrands from '../components/Admin/AdminBrand.vue'
import AdminScan from '../components/Admin/AdminScan.vue'

Vue.use(VueRouter)

const routes = [
    {
        path:'/', component: AppQRku,
        
    },
    {
        path:'/admin', component: Admin,
        children:[
            { path: '/admin', redirect: 'brand' },
            { path: 'brand', component: AdminBrands, },
            { path: 'brand/:brand', component: detailBrand, props:true, },
        ]
    },
    {
        path: '/scan', component: AdminScan,
    }
]

const router = new VueRouter({
    routes,
    hashbang: false,
    mode: 'history',
});

export default router;
