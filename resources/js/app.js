

require('./bootstrap');

window.Vue = require('vue').default;
// import VueSweetalert2 from 'vue-sweetalert2'
// Vue.use(VueSweetalert2);
//  Vue.config.productionTip = false
Vue.component('post', require('./components/PostComponent.vue').default);
import loader from "vue-ui-preloader";

Vue.use(loader);

const app = new Vue({
    el: '#app',
    components:{
        loader:loader
    }
});
