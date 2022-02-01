

require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('post', require('./components/PostComponent.vue').default);
Vue.component('addPost', require('./components/addPostComponent').default);


const app = new Vue({
    el: '#app',
});
