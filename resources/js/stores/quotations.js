const store = {
    namespaced: true,
    state: {
        total: 0,
        url: '/quotations',
        quotations: [],
        checked_quotations: [],
        loading: false,
        current_page: 1,
        filters: {},
    },
    getters: {
        getQuotations: state => state.quotations,
        getCheckedQuotations: state => state.checked_quotations,
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
        setQuotations: (state, {quotations}) => {
            state.quotations = quotations
        },
        setCheckedQuotations: (state, {quotations}) => {
            state.checked_quotations = quotations
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
        appendFilter: (state, {filters}) => {
            state.filters = {...state.filters, ...filters}
        },
        remove(state, {quotation}) {
            state.quotations = [..._.filter(state.quotations, value => value.id !== quotation.id)]
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
                    commit('setQuotations', {quotations: data.data})
                    commit('setTotal', {total: data.meta.total})
                    commit('setCurrentPage', {current_page: data.meta.current_page})
                })
                .catch(err => {
                    console.log(err)
                    commit('setLoading', {loading: false})
                })
        },
    }
}

export default store;
