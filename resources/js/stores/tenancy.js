const tenancy = {
    namespaced: true,
    state: {
        user_tenants: [],
        current_tenant: 2,
        user_roles: []
    },
    getters: {
        getTenants: state => state.user_tenants,
        getCurrentTenant: state => state.current_tenant,
        getUserRoles: state => state.user_roles,
    },
    mutations: {
        setTenants: (state, {tenants}) => state.user_tenants = tenants,
        setCurrentTenant: (state, {current_tenant}) => state.current_tenant = current_tenant,
        setUserRoles: (state, {user_roles}) => state.user_roles = user_roles,
    },
    actions: {
        init({commit}) {

        }
    }
}

export default tenancy;
