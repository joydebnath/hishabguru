const store = {
    namespaced: true,
    state: {
        total: '',
        url: '/suppliers',
        suppliers: [],
        loading: false,
        current_page: 1,
        filters: {}
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
        setFilters:(state, {filters})=>{
            state.filters = {...state.filters,...filters}
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
                    commit('setCurrentPage', {total: data.meta.current_page})
                })
                .catch(err => {
                    console.log(err)
                    commit('setLoading', {loading: false})
                })
        }
    }
}

export default store;
