<template>
  <b-dropdown aria-role="list">
    <span
        class="navbar-item text-base leading-6 px-3 py-2 font-medium focus:outline-none hover:no-underline"
        :class="[$props.active == 'accounting' ? 'text-blue-400 rounded font-semibold hover:text-blue-600' : 'text-gray-600 hover:text-gray-900 focus:text-gray-900']"
        slot="trigger"
        role="button"
    >
        <span>Accounting</span>
        <b-icon icon="menu-down"/>
    </span>
    <router-link to="/@/invoices">
      <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
        Invoices
      </b-dropdown-item>
    </router-link>
    <router-link to="/@/expenses">
      <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
        Expenses
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
