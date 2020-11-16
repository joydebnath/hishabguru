require('./bootstrap');

import Vue from 'vue'
import buefy from "buefy";

Vue.use(buefy)
import PublicQuotationComponent from './pages/public-quotation/PublicQuotationComponent'

const app = new Vue({
    el: '#app',
    components: {app: PublicQuotationComponent},
});
