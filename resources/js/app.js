
require('./bootstrap');

window.Vue = require('vue');

Vue.component('items-app', require('./components/ItemsApp.vue').default);
Vue.component('single-item', require('./components/SingleItem.vue').default);
Vue.component('add-item', require('./components/AddItem.vue').default);

const app = new Vue({
    el: '#app',
});
