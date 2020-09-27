<template>
    <b-dropdown aria-role="list">
        <span
            class="navbar-item text-sm leading-6 px-3 py-2 font-medium focus:outline-none hover:no-underline"
            :class="[$props.active == 'products' ? 'text-blue-400 rounded font-semibold hover:text-blue-600' : 'text-gray-600 hover:text-gray-900 focus:text-gray-900']"
            slot="trigger"
            role="button"
        >
            <span>Inventory</span>
            <b-icon icon="menu-down mt-1"/>
        </span>
        <router-link to="/@/products">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                Products
            </b-dropdown-item>
        </router-link>
        <router-link to="/@/product-categories">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                Product Categories
            </b-dropdown-item>
        </router-link>
<!--        <router-link to="/@/inventory-sites">-->
<!--            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">-->
<!--                Inventory Sites-->
<!--            </b-dropdown-item>-->
<!--        </router-link>-->
    </b-dropdown>
</template>

<script>
export default {
    name: "InventoryMenu",
    props: {
        active: String
    },
}
</script>

<style scoped>

</style>
