import {NotificationProgrammatic as Notification} from 'buefy'

const store = {
    namespaced: true,
    state: {
        total: '',
        url: '/suppliers',
        suppliers: [],
        loading: false,
        current_page: 1,
        getFilters: (state, getters, rootState, rootGetters) => {
            return {
                ...state.filters,
                tenant_id: rootGetters['tenancy/getCurrentTenant']
            }
        }
    },
    getters: {
        getSuppliers: state => state.suppliers,
        getUrl: state => state.url,
        getTotal: state => state.total,
        getLoading: state => state.loading,
        getCurrentPage: state => state.current_page,
        getFilters: state => state.filters
    },
    mutations: {
        setSuppliers: (state, {suppliers}) => {
            state.suppliers = suppliers
        },
        setLoading: (state, {loading}) => {
            state.loading = loading
        },
        setTotal: (state, {total}) => {
            state.total = total
        },
        setCurrentPage: (state, {current_page}) => {
            state.current_page = current_page
        },
        setFilters: (state, {filters}) => {
            state.filters = {...state.filters, ...filters}
        },
        update: (state, {supplier}) => {
            const index = _.findIndex(state.suppliers, value => value.id == supplier.id)
            if (index !== -1) {
                state.suppliers[index] = supplier;
                state.suppliers = [...state.suppliers]
            }
        }
    },
    actions: {
        loadData({commit, getters}, {page}) {
            commit('setLoading', {loading: true})
            axios
                .get(getters.getUrl + '?page=' + page, {
                    params: {...getters.getFilters}
                })
                .then(({data}) => {
                    commit('setLoading', {loading: false})
                    commit('setSuppliers', {suppliers: data.data})
                    commit('setTotal', {total: data.meta.total})
                    commit('setCurrentPage', {current_page: data.meta.current_page})
                })
                .catch(err => {
                    console.log(err)
                    commit('setLoading', {loading: false})
                })
        },
        delete({commit, getters, dispatch}){
            commit('setLoading', {loading: true})
            dispatch('loadData', {page: getters.getCurrentPage})
            Notification.open({
                message: data.message,
                type: 'is-success'
            });
            // ====== //
            if (err.response) {
                Notification.open({
                    message: err.response.data.message,
                    type: 'is-danger'
                })
            }
        }
    }
}

export default store;
