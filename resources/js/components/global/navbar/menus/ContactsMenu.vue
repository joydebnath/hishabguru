<template>
    <b-dropdown aria-role="list">
        <span
            class="navbar-item text-sm leading-6 px-3 py-2 font-medium focus:outline-none hover:no-underline"
            :class="[$props.active == 'contacts' ? 'text-blue-400 rounded font-semibold hover:text-blue-600' : 'text-gray-600 hover:text-gray-900 focus:text-gray-900']"
            slot="trigger"
            role="button"
        >
            <span>Contacts</span>
            <b-icon icon="menu-down mt-1"/>
        </span>
        <router-link to="/@/clients">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                Clients
            </b-dropdown-item>
        </router-link>
        <router-link to="/@/suppliers">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                Suppliers
            </b-dropdown-item>
        </router-link>
    </b-dropdown>
</template>

<script>
export default {
    name: "ContactsMenu",
    props: {
        active: String
    },
}
</script>

<style scoped>

</style>
