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
                <div class="flex flex-row">
                    <Timeline custom_class="h-5 w-5 text-indigo-600" />
                    <div class="flex flex-col pl-3">
                        <p class="text-sm leading-6 font-medium text-gray-900">Products</p>
                        <p class="text-xs leading-5 text-gray-500">List of all of your products and service</p>
                    </div>
                </div>
            </b-dropdown-item>
        </router-link>
        <router-link to="/@/product-categories">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                <div class="flex flex-row">
                    <Shopping custom_class="h-5 w-5 text-indigo-600" />
                    <div class="flex flex-col pl-3">
                        <p class="text-sm leading-6 font-medium text-gray-900">Product Categories</p>
                        <p class="text-xs leading-5 text-gray-500">List of your categories to classify products</p>
                    </div>
                </div>
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
import Timeline from "@/components/icons/Timeline";
import Shopping from "@/components/icons/Shopping";

export default {
    name: "InventoryMenu",
    components: {Shopping, Timeline},
    props: {
        active: String
    },
}
</script>

<style scoped>

</style>
