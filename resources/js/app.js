window.Vue = require('vue');

//window.axios = require('axios');

import AppComponent from './components/AppComponent.vue'
import Router from './router/router.js'
// import  from 'vuetify'
import Vuetify from 'vuetify' 
import axios from 'axios'
import VueQrcodeReader from "vue-qrcode-reader"
import VueQRCodeComponent from 'vue-qrcode-component';

Vue.component('qr-code', VueQRCodeComponent);

Vue.use(VueQrcodeReader);

window.axios = axios.create()

Vue.use(Vuetify,{
    iconfont: 'md'
});


const app = new Vue({
    el: '#app',
    components: {
        AppComponent,
    },
    router: Router,
    // render: h => h(AppComponent),
    
}); 
