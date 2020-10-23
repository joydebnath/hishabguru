<template>
    <b-dropdown aria-role="list">
       <span
           class="navbar-item text-sm leading-6 px-3 py-2 font-medium focus:outline-none hover:no-underline"
           :class="[$props.active == 'business' ? 'text-blue-400 rounded font-semibold hover:text-blue-600' : 'text-gray-600 hover:text-gray-900 focus:text-gray-900']"
           slot="trigger"
           role="button"
       >
           <span>Business</span>
           <b-icon icon="menu-down mt-1"></b-icon>
       </span>
        <router-link to="/@/quotations">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                <div class="flex flex-row">
                    <ShoppingBag custom_class="h-5 w-5"/>
                    <div class="flex flex-col pl-3">
                        <p class="text-sm leading-6 font-medium text-gray-900">Quotations</p>
                        <p class="text-xs leading-5 text-gray-500">Keep track of all of your purchase requests</p>
                    </div>
                </div>
            </b-dropdown-item>
        </router-link>
        <router-link to="/@/orders">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                <div class="flex flex-row">
                    <ShoppingCart custom_class="h-5 w-5"/>
                    <div class="flex flex-col pl-3">
                        <p class="text-sm leading-6 font-medium text-gray-900">Orders</p>
                        <p class="text-xs leading-5 text-gray-500">Organize and keep track of all of your orders</p>
                    </div>
                </div>
            </b-dropdown-item>
        </router-link>
        <span class="dropdown-divider"></span>
        <router-link to="/@/invoices">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                <div class="flex flex-row">
                    <PaperNote custom_class="h-5 w-5"/>
                    <div class="flex flex-col pl-3">
                        <p class="text-sm leading-6 font-medium text-gray-900">Invoices</p>
                        <p class="text-xs leading-5 text-gray-500">List of all of your invoices</p>
                    </div>
                </div>
            </b-dropdown-item>
        </router-link>
<!--        <span class="dropdown-divider"></span>-->
<!--        <span class="dropdown-header tracking-wider">E-commerce</span>-->
<!--        <router-link to="/@/marketplace">-->
<!--            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">-->
<!--                Marketplace-->
<!--            </b-dropdown-item>-->
<!--        </router-link>-->
<!--        <router-link to="/@/promo-codes">-->
<!--            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">-->
<!--                Promo Codes-->
<!--            </b-dropdown-item>-->
<!--        </router-link>-->
    </b-dropdown>
</template>

<script>
import ShoppingBag from "@/components/icons/ShoppingBag";
import ShoppingCart from "@/components/icons/ShoppingCart";
import PaperNote from "@/components/icons/PaperNote";

export default {
    name: "BusinessMenu",
    components: {ShoppingCart, ShoppingBag, PaperNote},
    props: {
        active: String
    },
}
</script>

<style scoped>

</style>
