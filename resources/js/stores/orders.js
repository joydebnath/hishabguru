import {NotificationProgrammatic as Notification} from 'buefy'

const store = {
    namespaced: true,
    state: {
        total: '',
        url: '/orders',
        orders: [],
        loading: false,
        current_page: 1,
        filters: {},
        checked_orders: [],
    },
    getters: {
        getOrders: state => state.orders,
        getCheckedOrders: state => state.checked_orders,
        getUrl: state => state.url,
        getTotal: state => state.total,
        getLoading: state => state.loading,
        getCurrentPage: state => state.current_page,
        getFilters: (state, getters, rootState, rootGetters) => {
            return {
                ...state.filters,
                tenant_id: rootGetters['tenancy/getCurrentTenant']
            }
        }
    },
    mutations: {
        setOrders: (state, {orders}) => {
            state.orders = orders
        },
        setCheckedOrders: (state, {orders}) => {
            state.checked_orders = orders
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
                    commit('setOrders', {orders: data.data})
                    commit('setTotal', {total: data.meta.total})
                    commit('setCurrentPage', {current_page: data.meta.current_page})
                })
                .catch(err => {
                    console.log(err)
                    commit('setLoading', {loading: false})
                })
        },
        delete({commit, getters, dispatch}, {order}) {
            commit('setLoading', {loading: true})
            axios
                .delete(getters.getUrl + '/' + order.id)
                .then(({data}) => {
                    commit('setLoading', {loading: false})
                    Notification.open({
                        message: data.message,
                        type: 'is-success is-light'
                    });
                    dispatch('loadData', {page: getters.getCurrentPage})
                })
                .catch(err => {
                    console.log(err)
                    if (err.response) {
                        Notification.open({
                            message: err.response.data.message,
                            type: 'is-danger is-light'
                        })
                    }
                    commit('setLoading', {loading: false})
                })
        }
    }
};

export default store;
