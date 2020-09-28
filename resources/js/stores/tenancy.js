const tenancy = {
    namespaced: true,
    state: {
        user_tenants: [],
        current_tenant: 2,
        user_current_roles: [],
    },
    getters: {
        getTenants: state => state.user_tenants,
        getCurrentTenant: state => state.current_tenant,
        getUserRoles: state => state.user_current_roles,
    },
    mutations: {
        setTenants: (state, {tenants}) => state.user_tenants = tenants,
        setCurrentTenant: (state, {current_tenant}) => state.current_tenant = current_tenant,
        setUserRoles: (state, {roles}) => state.user_current_roles = roles,
    },
    actions: {
        init({commit}) {

        }
    }
}

export default tenancy;
