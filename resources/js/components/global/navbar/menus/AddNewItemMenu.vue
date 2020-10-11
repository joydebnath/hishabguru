<template>
    <b-dropdown aria-role="list" class="add-items">
        <span class="navbar-item text-center rounded-full h-8 w-8" slot="trigger" role="button">
            <b-tooltip label="Add" position="is-left" type="is-dark">
                <svg class="text-gray-700" width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M12 5V19M5 12H19" stroke="#000" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                    </path>
                </svg>
            </b-tooltip>
        </span>
        <router-link to="/@/quotations/create">
            <b-dropdown-item class="py-3" aria-role="listitem" custom-class="outline-none">
                <div class="media">
                    <div class="media-content">
                        <h3>New Quotation</h3>
                    </div>
                </div>
            </b-dropdown-item>
        </router-link>
        <router-link to="/@/orders/create">
            <b-dropdown-item class="py-3" aria-role="listitem" custom-class="outline-none">
                <div class="media">
                    <div class="media-content">
                        <h3>New Order</h3>
                    </div>
                </div>
            </b-dropdown-item>
        </router-link>
        <router-link to="/@/invoices/create">
            <b-dropdown-item class="py-3" aria-role="listitem" custom-class="outline-none">
                <div class="media">
                    <div class="media-content">
                        <h3>New Invoice</h3>
                    </div>
                </div>
            </b-dropdown-item>
        </router-link>
        <router-link to="/@/purchases/create">
            <b-dropdown-item class="py-3" aria-role="listitem" custom-class="outline-none">
                <div class="media">
                    <div class="media-content">
                        <h3>New Purchase</h3>
                    </div>
                </div>
            </b-dropdown-item>
        </router-link>
        <router-link to="/@/bills/create">
            <b-dropdown-item class="py-3" aria-role="listitem" custom-class="outline-none">
                <div class="media">
                    <div class="media-content">
                        <h3>New Bill</h3>
                    </div>
                </div>
            </b-dropdown-item>
        </router-link>
        <router-link to="/@/other-expenses/create">
            <b-dropdown-item class="py-3" aria-role="listitem" custom-class="outline-none">
                <div class="media">
                    <div class="media-content">
                        <h3>New Other Expense</h3>
                    </div>
                </div>
            </b-dropdown-item>
        </router-link>
    </b-dropdown>
</template>

<script>
export default {
    name: "MenuForAddNewItem"
}
</script>

<style>
.add-items .dropdown-menu .dropdown-content {
    padding-bottom: 0;
    padding-top: 0;
}

.add-items .dropdown-menu {
    padding-top: 0;
    left: -5rem;
}
</style>
