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
                <div class="flex flex-row">
                    <CreditCard custom_class="h-5 w-5 text-indigo-600"/>
                    <div class="flex flex-col pl-3">
                        <p class="text-sm leading-6 font-medium text-gray-900">Bills to pay</p>
                        <p class="text-xs leading-5 text-gray-500">Keep track of all of your bills.</p>
                    </div>
                </div>
            </b-dropdown-item>
        </router-link>
        <span class="dropdown-divider"></span>
        <router-link to="/@/purchases">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                <div class="flex flex-row">
                    <Store custom_class="h-5 w-5"/>
                    <div class="flex flex-col pl-3">
                        <p class="text-sm leading-6 font-medium text-gray-900">Purchases</p>
                        <p class="text-xs leading-5 text-gray-500">Organize all of your Purchase orders</p>
                    </div>
                </div>
            </b-dropdown-item>
        </router-link>
        <router-link to="/@/other-expenses">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                <div class="flex flex-row">
                    <Wallet custom_class="h-5 w-5"/>
                    <div class="flex flex-col pl-3">
                        <p class="text-sm leading-6 font-medium text-gray-900">Other expenses</p>
                        <p class="text-xs leading-5 text-gray-500">Keep track of all of your other expenses</p>
                    </div>
                </div>
            </b-dropdown-item>
        </router-link>
    </b-dropdown>
</template>

<script>
import CreditCard from "@/components/icons/CreditCard";
import Store from "@/components/icons/Store";
import Wallet from "@/components/icons/Wallet";

export default {
    name: "AccountingMenu",
    components: {Wallet, Store, CreditCard},
    props: {
        active: String
    },
}
</script>
