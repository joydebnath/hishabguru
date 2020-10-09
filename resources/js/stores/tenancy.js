const tenancy = {
    namespaced: true,
    state: {
        user_tenants: [],
        current_tenant: null,
        current_tenant_data: {},
        user_current_roles: [],
        current_inventories: []
    },
    getters: {
        getTenants: state => state.user_tenants,
        getCurrentTenant: state => state.current_tenant,
        getCurrentTenantData: state => state.current_tenant_data,
        getCurrentInventories: state => state.current_inventories,
        getUserRoles: state => state.user_current_roles,
    },
    mutations: {
        setTenants: (state, {tenants}) => state.user_tenants = tenants,
        setCurrentTenant: (state, {current_tenant_id}) => state.current_tenant = current_tenant_id,
        setCurrentTenantData: (state, {current_tenant}) => state.current_tenant_data = current_tenant,
        setCurrentInventories: (state, {inventories}) => state.current_inventories = inventories,
        setUserRoles: (state, {roles}) => state.user_current_roles = roles,
    },
    actions: {
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
