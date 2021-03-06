const store = {
    namespaced: true,
    state: {
        total: '',
        url: '/clients',
        clients: [],
        loading: false,
        current_page: 1,
        filters: {}
    },
    getters: {
        getClients: state => state.clients,
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
        setClients: (state, {clients}) => {
            state.clients = clients
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
        update: (state, {client}) => {
            const index = _.findIndex(state.clients, value => value.id == client.id)
            if (index !== -1) {
                state.clients[index] = client;
                state.clients = [...state.clients]
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
                    commit('setClients', {clients: data.data})
                    commit('setTotal', {total: data.meta.total})
                    commit('setCurrentPage', {current_page: data.meta.current_page})
                })
                .catch(err => {
                    console.log(err)
                    commit('setLoading', {loading: false})
                })
        },
        delete({commit, getters, dispatch}) {
            commit('setLoading', {loading: true})
            dispatch('loadData', {page: getters.getCurrentPage})
        }
    }
}

export default store;
