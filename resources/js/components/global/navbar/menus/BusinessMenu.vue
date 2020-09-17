<template>
    <b-dropdown aria-role="list">
   <span
       class="navbar-item text-base leading-6 px-3 py-2 font-medium focus:outline-none hover:no-underline"
       :class="[$props.active == 'business' ? 'text-blue-400 rounded font-semibold hover:text-blue-600' : 'text-gray-600 hover:text-gray-900 focus:text-gray-900']"
       slot="trigger"
       role="button"
   >
     <span>Business</span>
        <b-icon icon="menu-down"/>
    </span>
        <router-link to="/@/quotations">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                Quotations
            </b-dropdown-item>
        </router-link>
        <router-link to="/@/orders">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                Orders
            </b-dropdown-item>
        </router-link>
        <router-link to="/@/purchase">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                Purchases
            </b-dropdown-item>
        </router-link>
        <span class="dropdown-divider"></span>
        <span class="dropdown-header tracking-wider">E-commerce</span>
        <router-link to="/@/marketplace">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                Marketplace
            </b-dropdown-item>
        </router-link>
        <router-link to="/@/promo-codes">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                Promo Codes
            </b-dropdown-item>
        </router-link>
    </b-dropdown>
</template>

<script>
export default {
    name: "BusinessMenu",
    props: {
        active: String
    },
}
</script>

<style scoped>

</style>
