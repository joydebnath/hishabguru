const store = {
    namespaced: true,
    state: {
        total: '',
        url: '/other-expenses',
        expenses: [],
        loading: false,
        current_page: 1,
        filters: {},
        checked_expenses: [],
    },
    getters: {
        getExpenses: state => state.expenses,
        getUrl: state => state.url,
        getTotal: state => state.total,
        getLoading: state => state.loading,
        getCurrentPage: state => state.current_page,
        getFilters: (state, getters, rootState, rootGetters) => {
            return {
                ...state.filters,
                tenant_id: rootGetters['tenancy/getCurrentTenant']
            }
        },
        getCheckedExpenses: state => state.checked_expenses,
    },
    mutations: {
        setExpenses: (state, {expenses}) => {
            state.expenses = expenses
        },
        setCheckedExpenses: (state, {expenses}) => {
            state.checked_expenses = expenses
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
                    commit('setExpenses', {expenses: data.data})
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

export default store
