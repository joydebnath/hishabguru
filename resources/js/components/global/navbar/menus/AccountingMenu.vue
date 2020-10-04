<template>
    <b-dropdown aria-role="list">
    <span
        class="navbar-item text-sm leading-6 px-3 py-2 font-medium focus:outline-none hover:no-underline"
        :class="[$props.active == 'accounting' ? 'text-blue-400 rounded font-semibold hover:text-blue-600' : 'text-gray-600 hover:text-gray-900 focus:text-gray-900']"
        slot="trigger"
        role="button"
    >
        <span>Accounting</span>
        <b-icon icon="menu-down mt-1"/>
    </span>
        <span class="dropdown-header tracking-wider">Banking</span>
        <router-link to="/@/marketplace">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                Bkash
            </b-dropdown-item>
        </router-link>
        <router-link to="/@/promo-codes">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                SSLCommerz
            </b-dropdown-item>
        </router-link>
        <span class="dropdown-divider"></span>
        <router-link to="/@/accounts-chart">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                Chart of Accounts
            </b-dropdown-item>
        </router-link>
        <span class="dropdown-divider"></span>
        <span class="dropdown-header tracking-wider">Reports</span>
        <router-link to="/@/balance-sheet">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                Balance sheet
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
