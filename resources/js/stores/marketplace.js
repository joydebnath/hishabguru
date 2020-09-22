import {NotificationProgrammatic as Notification} from 'buefy'

const products = {
    namespaced: true,
    state: {
        total: 0,
        url: '/marketplace',
        products: [],
        loading: false,
        current_page: 1,
        filters: {}
    },
    getters: {
        getProducts: state => state.products,
        getUrl: state => state.url,
        getTotal: state => state.total,
        getLoading: state => state.loading,
        getCurrentPage: state => state.current_page,
        getFilters: state => state.filters,
    },
    mutations: {
        setProducts: (state, {products}) => {
            state.products = products
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
        },
        update: (state, {product}) => {
            const index = _.findIndex(state.products, value => value.id == product.id)
            if (index !== -1) {
                state.products[index] = product;
                state.products = [...state.products]
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
                    commit('setProducts', {products: data.data})
                    commit('setTotal', {total: data.meta.total})
                    commit('setCurrentPage', {current_page: data.meta.current_page})
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

export default products;
