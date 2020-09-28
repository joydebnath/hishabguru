<template>
    <b-dropdown aria-role="list" class="add-items">
        <span class="navbar-item text-center rounded-full h-8 w-8" slot="trigger" role="button">
            <b-tooltip label="Add" position="is-left" type="is-dark">
                <span class="text-2xl text-gray-700">+</span>
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
