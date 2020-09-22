import {NotificationProgrammatic as Notification} from 'buefy'

const store = {
    namespaced: true,
    state: {
        total: '',
        url: '/invoices',
        invoices: [],
        loading: false,
        current_page: 1,
        filters: {}
    },
    getters: {
        getInvoices: state => state.invoices,
        getUrl: state => state.url,
        getTotal: state => state.total,
        getLoading: state => state.loading,
        getCurrentPage: state => state.current_page,
        getFilters: state => state.filters
    },
    mutations: {
        setInvoices: (state, {invoices}) => {
            state.invoices = invoices
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
                .get(getters.getUrl + '?page=' + page)
                .then(({data}) => {
                    commit('setLoading', {loading: false})
                    commit('setInvoices', {invoices: data.data})
                    commit('setTotal', {total: data.meta.total})
                    commit('setCurrentPage', {total: data.meta.current_page})
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
