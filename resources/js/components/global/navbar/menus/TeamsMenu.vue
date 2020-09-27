<template>
    <b-dropdown aria-role="list">
        <span
            class="navbar-item text-sm leading-6 px-3 py-2 font-medium focus:outline-none hover:no-underline"
            :class="[$props.active == 'teams' ? 'text-blue-400 rounded font-semibold hover:text-blue-600' : 'text-gray-600 hover:text-gray-900 focus:text-gray-900']"
            slot="trigger"
            role="button"
        >
            <span>Teams</span>
            <b-icon icon="menu-down mt-1"/>
        </span>
        <router-link to="/@/employees">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                Employees
            </b-dropdown-item>
        </router-link>
<!--        <router-link to="/@/leave-management">-->
<!--            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">-->
<!--                Leave Management-->
<!--            </b-dropdown-item>-->
<!--        </router-link>-->
    </b-dropdown>
</template>

<script>
export default {
    name: "TeamsMenu",
    props: {
        active: String
    },
}
</script>

<style scoped>

</style>
