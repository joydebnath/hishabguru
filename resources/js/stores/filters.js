const filters = {
    namespaced: true,
    state: {
        product_categories: []
    },
    getters: {
        getProductCategories: state => state.product_categories
    },
    mutations: {
        set(state, {product_categories}) {
            state.product_categories = product_categories;
        }
    },
    actions: {
        init({commit, getters}) {
            axios
                .get('/filters')
                .then(({data}) => {
                    commit('set', data.data)
                })
                .catch(err => {
                    console.log(err)
                })
        }
    }
}

export default filters;
