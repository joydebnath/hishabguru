import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import filtersModule from './filters'
import productsModule from './products'
import productCategoriesModule from '../stores/product-categories'
import inventorySitesModule from '../stores/inventory-sites'
import quotationsModule from './quotations'
import ordersModule from './orders'
import promoCodesModule from './promo-codes'
import invoicesModule from './invoices'
import dashboardModule from './dashboard'
import clientsModule from './clients'
import suppliersModule from './suppliers'
import tenancyModule from "./tenancy";
import marketplaceModule from './marketplace'
import expensesModule from './expenses'

const store = new Vuex.Store({
    namespaced: true,
    modules: {
        products: productsModule,
        filters: filtersModule,
        product_categories: productCategoriesModule,
        quotations: quotationsModule,
        orders: ordersModule,
        promo_codes: promoCodesModule,
        invoices: invoicesModule,
        dashboard: dashboardModule,
        clients: clientsModule,
        suppliers: suppliersModule,
        tenancy: tenancyModule,
        marketplace: marketplaceModule,
        expenses: expensesModule,
        inventory_sites: inventorySitesModule
    },
    state: {
        per_page: 15,
        title: '',
        page_type: ''
    },
    getters: {
        getPerPage: state => state.per_page,
        getTitle: state => state.title,
        getPageType: state => state.page_type,
    },
    mutations: {
        setTitle: (state, {title}) => state.title = title,
        setPageType: (state, {type}) => state.page_type = type,
    },
    actions: {}
});

export default store;
