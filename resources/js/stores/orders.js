const store = {
    namespaced: true,
    state: {
        total: '',
        url: '/orders',
        orders: [],
        loading: false,
        current_page: 1,
        filters: {}
    },
    getters: {
        getOrders: state => state.orders,
        getUrl: state => state.url,
        getTotal: state => state.total,
        getLoading: state => state.loading,
        getCurrentPage: state => state.current_page,
        getFilters: state => state.filters
    },
    mutations: {
        setOrders: (state, {orders}) => {
            state.orders = orders
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
                .get(getters.getUrl + '?page=' + page)
                .then(({data}) => {
                    commit('setLoading', {loading: false})
                    commit('setOrders', {orders: data.data})
                    commit('setTotal', {total: data.meta.total})
                    commit('setCurrentPage', {total: data.meta.current_page})
                })
                .catch(err => {
                    console.log(err)
                    commit('setLoading', {loading: false})
                })
        }
    }
};

export default store;
