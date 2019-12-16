import Vue from 'vue'
import App from './App.vue'
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'vue2-datepicker/index.css'
import 'vue-toast-notification/dist/index.css'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueToast from 'vue-toast-notification'


Vue.config.productionTip = false
Vue.use(VueToast);
Vue.use(VueAxios, axios)
new Vue({
    render: h => h(App),
}).$mount('#app')