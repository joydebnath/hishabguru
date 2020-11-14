require('./bootstrap');

import Vue from 'vue'
import buefy from "buefy";

Vue.use(buefy)
import InvoiceComponent from './pages/public-invoice/PublicInvoiceComponent'

const app = new Vue({
    el: '#app',
    components: {app: InvoiceComponent},
});
