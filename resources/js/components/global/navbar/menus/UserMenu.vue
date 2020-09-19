<template>
    <b-dropdown aria-role="list">
            <span class="navbar-item" slot="trigger" role="button">
                <span>{{ username }}</span>
                <b-icon icon="menu-down"/>
            </span>
        <small class="dropdown-header uppercase tracking-wider">Businesses</small>
        <b-dropdown-item class="py-3" aria-role="listitem">
            <div class="media">
                <div class="media-content">
                    <h3>Meghomitra</h3>
                </div>
            </div>
        </b-dropdown-item>
        <hr class="dropdown-divider ">
        <router-link to="/@/settings">
            <b-dropdown-item class="py-2" aria-role="listitem">
                Settings
            </b-dropdown-item>
        </router-link>
        <b-dropdown-item class="py-2" aria-role="listitem" @click="handleLogout">
            <div class="media">
                <div class="media-content">
                    <h3>Logout</h3>
                </div>
            </div>
        </b-dropdown-item>
    </b-dropdown>
</template>

<script>
export default {
    name: "UserMenu",
    props: {
        username: String,
        tenants: Array
    },
    data() {
        return {}
    },
    methods: {
        handleLogout() {
            document.getElementById('logout-form').submit();
        }
    }
}
</script>

<style>
a {
    text-decoration: none !important;
}

.dropdown-menu {
    padding-bottom: 0
}
</style>
