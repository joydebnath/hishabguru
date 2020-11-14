require('./bootstrap');

import Vue from 'vue'

import SetupInventory from './pages/setup/SetupInventory'

const app = new Vue({
    el: '#app',
    components: {app: SetupInventory},
});
