<template>
    <b-dropdown aria-role="list">
        <div class="navbar-item text-sm" slot="trigger" role="button">
            <span style="width: 135px" v-if="user_loading">
                <b-skeleton :animated="true"/>
            </span>
            <template v-else>
                <span>{{ username }}</span>
                <b-icon icon="pan-down -mt-1"/>
            </template>
        </div>
        <small class="dropdown-header uppercase tracking-wider">Switch Business</small>
        <b-dropdown-item class="py-3" aria-role="listitem">
            <div class="media">
                <div class="media-content">
                    <p class="mb-0" v-for="tenant in tenants">
                        <CheckCircleIcon v-if="tenant.id === current_tenant"/>
                        {{ tenant.name }}
                    </p>
                </div>
            </div>
        </b-dropdown-item>
        <hr class="dropdown-divider ">
        <small class="dropdown-header uppercase tracking-wider">Business Settings</small>
        <router-link to="/@/business-settings">
            <b-dropdown-item class="py-2" aria-role="listitem">
                Settings
            </b-dropdown-item>
        </router-link>
        <hr class="dropdown-divider ">
        <small class="dropdown-header uppercase tracking-wider">Business Data</small>
        <router-link to="/@/import-data">
            <b-dropdown-item class="py-2" aria-role="listitem">
                Import Data
            </b-dropdown-item>
        </router-link>
        <hr class="dropdown-divider ">
        <router-link to="/@/profile">
            <b-dropdown-item class="py-2" aria-role="listitem">
                Profile
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
import {mapGetters} from 'vuex'
import CheckCircleIcon from "@/components/icons/CheckCircleIcon";

export default {
    name: "UserMenu",
    components: {CheckCircleIcon},
    methods: {
        handleLogout() {
            document.getElementById('logout-form').submit();
        }
    },
    computed: {
        ...mapGetters({
            user: 'getUser',
            user_loading: 'getLoadingUser',
            current_tenant: 'tenancy/getCurrentTenant',
            tenants: 'tenancy/getTenants'
        }),
        username() {
            return this.user ? this.user.name : null
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
