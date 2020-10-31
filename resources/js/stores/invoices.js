const store = {
    namespaced: true,
    state: {
        total: '',
        url: '/invoices',
        invoices: [],
        loading: false,
        current_page: 1,
        filters: {},
        checked_invoices: [],
    },
    getters: {
        getInvoices: state => state.invoices,
        getCheckedInvoices: state => state.checked_invoices,
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
        setInvoices: (state, {invoices}) => {
            state.invoices = invoices
        },
        setCheckedInvoices: (state, {invoices}) => {
            state.checked_invoices = invoices
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
            state.filters = {...filters}
        },
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
                    commit('setInvoices', {invoices: data.data})
                    commit('setTotal', {total: data.meta.total})
                    commit('setCurrentPage', {current_page: data.meta.current_page})
                })
                .catch(err => {
                    console.log(err)
                    commit('setLoading', {loading: false})
                })
        },
    }
};

export default store;
