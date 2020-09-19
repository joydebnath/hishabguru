<template>
    <b-dropdown aria-role="list" class="add-items">
            <span class="navbar-item py-0 px-2" slot="trigger" role="button">
                <b-tooltip label="Add" position="is-left" type="is-dark">
                    <span class="text-2xl text-gray-600">+</span>
                </b-tooltip>
            </span>
        <b-dropdown-item class="py-3" aria-role="listitem" custom-class="outline-none">
            <div class="media">
                <div class="media-content">
                    <h3>New Order</h3>
                </div>
            </div>
        </b-dropdown-item>
        <b-dropdown-item class="py-3" aria-role="listitem" custom-class="outline-none">
            <div class="media">
                <div class="media-content">
                    <h3>New Expense</h3>
                </div>
            </div>
        </b-dropdown-item>
        <b-dropdown-item class="py-3" aria-role="listitem" custom-class="outline-none">
            <div class="media">
                <div class="media-content">
                    <h3>New Purchase</h3>
                </div>
            </div>
        </b-dropdown-item>
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
