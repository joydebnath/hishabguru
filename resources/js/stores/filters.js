const filters = {
    namespaced: true,
    state: {

    },
    getters: {

    },
    mutations: {

    },
    actions: {
        init({commit, getters}) {
            axios
                .get('/filters')
                .then(({data}) => {

                })
                .catch(err => {
                    console.log(err)
                })
        }
    }
}

export default filters;
