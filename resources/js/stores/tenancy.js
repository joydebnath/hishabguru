const tenancy = {
    namespaced: true,
    state: {
        user_tenants: [],
        current_tenant: null,
        user_current_roles: [],
        current_inventories: []
    },
    getters: {
        getTenants: state => state.user_tenants,
        getCurrentTenant: state => state.current_tenant,
        getCurrentInventories: state => state.current_inventories,
        getUserRoles: state => state.user_current_roles,
    },
    mutations: {
        setTenants: (state, {tenants}) => state.user_tenants = tenants,
        setCurrentTenant: (state, {current_tenant}) => state.current_tenant = current_tenant,
        setCurrentInventories: (state, {inventories}) => state.current_inventories = inventories,
        setUserRoles: (state, {roles}) => state.user_current_roles = roles,
    },
    actions: {
        init: ({getters, commit, dispatch}) => {
            axios
                .get('/user-tenancies')
                .then(({data}) => {
                    commit('setTenants', {tenants: data.data})
                    const FIRST = _.first(data.data);
                    commit('setCurrentTenant', {current_tenant: FIRST ? FIRST.id : null})
                    commit('setUserRoles', {roles: FIRST ? FIRST.user_roles : []})
                    if (getters.getCurrentTenant) {
                        dispatch('loadCurrentTenancyData')
                    }
                })
                .catch(err => {
                    console.error(err)
                })
        },
        loadCurrentTenancyData: ({commit, getters}) => {
            axios
                .get('/tenants/' + getters.getCurrentTenant)
                .then(({data}) => {
                    commit('setCurrentInventories', {inventories: data.data.inventories})
                })
                .catch(err => {
                    console.error(err)
                })
        }
    }
}

export default tenancy;
