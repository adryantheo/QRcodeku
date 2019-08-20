import Vue from 'vue'
import VueRouter from 'vue-router'
import AppQRku from '../components/QRku.vue'
import Admin from '../components/Admin/AdminLanding.vue'
import detailBrand from '../components/Admin/detailBrand.vue'
import AdminBrands from '../components/Admin/AdminBrand.vue'

Vue.use(VueRouter)

const routes = [
    {
        path:'/', component: AppQRku,
        
    },
    {
        path:'/admin', component: Admin,
        children:[
            {
                path: 'brand',
                component: AdminBrands,
            },
            {
                path: 'brand/:brand',
                component: detailBrand,
                props:true,
            },
        ]
    },
    // {
    //     path: '/brand', component: adminCredit,
    // }
]

const router = new VueRouter({
    routes,
    hashbang: false,
    mode: 'history',
});

export default router;
