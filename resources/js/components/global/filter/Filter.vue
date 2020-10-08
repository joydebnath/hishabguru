<template>
    <div class="custom-filter">
        <b-dropdown aria-role="list" :close-on-click="false">
            <button
                class="button text-gray-800 is-outlined is-info hover:text-white focus:text-white text-blue-600"
                slot="trigger"
            >
                <FilterIcon/>
                <span class="ml-2">Filters</span>
            </button>
            <div class="modal-card w-full">
                <section class="modal-card-body">
                    <slot></slot>
                </section>
                <footer class="modal-card-foot bg-white p-4 flex justify-content-end">
                    <button class="button is-primary" @click="$emit('apply')">
                        Apply
                    </button>
                    <button class="button is-light" @click="$emit('clear')">
                        Clear
                    </button>
                </footer>
            </div>
        </b-dropdown>
    </div>
</template>

<script>
import FilterIcon from "../../icons/FilterIcon";
export default {
    components: {FilterIcon},
    data() {
        return {
            checkboxGroup: []
        };
    }
};
</script>

<style>
.custom-filter .dropdown-menu {
    padding: 0 !important;
    width: 500px;
}
.custom-filter .dropdown-content {
    padding: 0;
}
</style>
