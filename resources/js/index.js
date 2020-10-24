require('./bootstrap');

import Vue from 'vue'
import buefy from "buefy";

Vue.use(buefy)

import store from './stores/index'
import router from './route'
import App from './components/App'

const app = new Vue({
    el: '#app',
    components: {app: App},
    router,
    store
});
