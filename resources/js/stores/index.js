import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import productsModule from './products'
import productCategoriesModule from './product-categories'
// import inventorySitesModule from './inventory-sites'
import quotationsModule from './quotations'
import ordersModule from './orders'
import purchasesModule from './purchases'
import promoCodesModule from './promo-codes'
import invoicesModule from './invoices'
import dashboardModule from './dashboard'
import clientsModule from './clients'
import suppliersModule from './suppliers'
import employeesModule from './employees'
import tenancyModule from "./tenancy";
import marketplaceModule from './marketplace'
import otherExpensesModule from './other-expenses'
import billsModule from './bills'

const store = new Vuex.Store({
    namespaced: true,
    modules: {
        bills: billsModule,
        products: productsModule,
        product_categories: productCategoriesModule,
        quotations: quotationsModule,
        orders: ordersModule,
        purchases: purchasesModule,
        promo_codes: promoCodesModule,
        invoices: invoicesModule,
        dashboard: dashboardModule,
        clients: clientsModule,
        suppliers: suppliersModule,
        employees: employeesModule,
        tenancy: tenancyModule,
        marketplace: marketplaceModule,
        other_expenses: otherExpensesModule,
        // inventory_sites: inventorySitesModule
    },
    state: {
        per_page: 15,
        title: '',
        page_type: '',
        user: null,
        loading_user: false,
        logo: ''
    },
    getters: {
        getPerPage: state => state.per_page,
        getTitle: state => state.title,
        getLogo: state => state.logo,
        getPageType: state => state.page_type,
        getUser: state => state.user,
        getLoadingUser: state => state.loading_user,
    },
    mutations: {
        setTitle: (state, {title}) => state.title = title,
        setLogo: (state, {url}) => state.logo = url,
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

                    if (data.data.user.current_tenant_id) {
                        commit('tenancy/setCurrentTenant', {current_tenant_id: data.data.user.current_tenant_id})
                        const CURRENT_TENANT = _.find(data.data.tenants, value => value.id === data.data.user.current_tenant_id);
                        commit('tenancy/setCurrentTenantData', {current_tenant: CURRENT_TENANT ? CURRENT_TENANT : null})
                        commit('tenancy/setUserRoles', {roles: CURRENT_TENANT ? CURRENT_TENANT.user_roles : []})
                        if (CURRENT_TENANT) {
                            dispatch('tenancy/loadCurrentTenancyData')
                        }
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
