<template>
    <b-dropdown aria-role="list">
    <span
        class="navbar-item text-sm leading-6 px-3 py-2 font-medium focus:outline-none hover:no-underline"
        :class="[$props.active == 'expenses' ? 'text-blue-400 rounded font-semibold hover:text-blue-600' : 'text-gray-600 hover:text-gray-900 focus:text-gray-900']"
        slot="trigger"
        role="button"
    >
        <span>Expenses</span>
        <b-icon icon="menu-down mt-1"/>
    </span>
        <router-link to="/@/bills">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                Bills to pay
            </b-dropdown-item>
        </router-link>
        <span class="dropdown-divider"></span>
        <router-link to="/@/purchases">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                Purchases
            </b-dropdown-item>
        </router-link>
        <router-link to="/@/other-expenses">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                Other expenses
            </b-dropdown-item>
        </router-link>
    </b-dropdown>
</template>

<script>
export default {
    name: "AccountingMenu",
    props: {
        active: String
    },
}
</script>
