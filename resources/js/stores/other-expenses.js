import {NotificationProgrammatic as Notification} from "buefy";

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
        getFilters: state => state.filters,
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
        delete({commit, getters, dispatch}, {bill}) {
            commit('setLoading', {loading: true})
            axios
                .delete(getters.getUrl + '/' + bill.id)
                .then(({data}) => {
                    commit('setLoading', {loading: false})
                    Notification.open({
                        message: data.message,
                        type: 'is-success is-light',
                        duration: 5000
                    });
                    dispatch('loadData', {page: getters.getCurrentPage})
                })
                .catch(err => {
                    console.log(err)
                    if (err.response) {
                        Notification.open({
                            message: err.response.data.message,
                            type: 'is-danger is-light',
                            duration: 5000
                        })
                    }
                    commit('setLoading', {loading: false})
                })
        }
    }
}

export default store
