import {NotificationProgrammatic as Notification} from 'buefy'

const store = {
    namespaced: true,
    state: {
        total: '',
        url: '/employees',
        employees: [],
        checked_employees: [],
        loading: false,
        current_page: 1,
        filters: {}
    },
    getters: {
        getEmployees: state => state.employees,
        getCheckedEmployees: state => state.checked_employees,
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
        setEmployees: (state, {employees}) => {
            state.employees = employees
        },
        setCheckedEmployees: (state, {employees}) => {
            state.checked_employees = employees
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
        update: (state, {employee}) => {
            const index = _.findIndex(state.employees, value => value.id == employee.id)
            if (index !== -1) {
                state.employees[index] = employee;
                state.employees = [...state.employees]
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
                    commit('setEmployees', {employees: data.data})
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
