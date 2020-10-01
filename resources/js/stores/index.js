import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import filtersModule from './filters'
import productsModule from './products'
import productCategoriesModule from '../stores/product-categories'
import inventorySitesModule from '../stores/inventory-sites'
import quotationsModule from './quotations'
import ordersModule from './orders'
import purchasesModule from './purchases'
import promoCodesModule from './promo-codes'
import invoicesModule from './invoices'
import dashboardModule from './dashboard'
import clientsModule from './clients'
import suppliersModule from './suppliers'
import tenancyModule from "./tenancy";
import marketplaceModule from './marketplace'
import expensesModule from './expenses'
import billsModule from './bills'

const store = new Vuex.Store({
    namespaced: true,
    modules: {
        bills: billsModule,
        products: productsModule,
        filters: filtersModule,
        product_categories: productCategoriesModule,
        quotations: quotationsModule,
        orders: ordersModule,
        purchases: purchasesModule,
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
        page_type: '',
        user: null,
        loading_user: false
    },
    getters: {
        getPerPage: state => state.per_page,
        getTitle: state => state.title,
        getPageType: state => state.page_type,
        getUser: state => state.user,
        getLoadingUser: state => state.loading_user,
    },
    mutations: {
        setTitle: (state, {title}) => state.title = title,
        setPageType: (state, {type}) => state.page_type = type,
        setUser: (state, {user}) => state.user = user,
        setLoadingUser: (state, value) => state.loading_user = value,
    },
    actions: {
        init: ({commit, dispatch}) => {
            commit('setLoadingUser', true)
            axios
                .get('/me')
                .then(({data}) => {
                    commit('setUser', {user: data.data.user})
                    commit('tenancy/setTenants', {tenants: data.data.tenants})

                    const FIRST = _.first(data.data.tenants);
                    commit('tenancy/setCurrentTenant', {current_tenant: FIRST ? FIRST.id : null})
                    commit('tenancy/setUserRoles', {roles: FIRST ? FIRST.user_roles : []})

                    if (FIRST) {
                        dispatch('tenancy/loadCurrentTenancyData')
                    }

                    commit('setLoadingUser', false)
                })
                .catch(err => {
                    console.error(err)
                    commit('setLoadingUser', false)
                })
        }
    }
});

export default store;
