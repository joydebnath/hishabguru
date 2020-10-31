<template>
    <section>
        <button
            class="button text-gray-800 text-sm tracking-wide is-outlined is-info hover:text-white focus:text-white text-blue-600"
            @click="toggleSlider"
        >
            <FilterIcon/>
            <span class="ml-1">Filters</span>
        </button>
        <b-sidebar
            :fullheight="true"
            :fullwidth="false"
            :overlay="false"
            v-model="open"
            class="custom-filter"
            :can-cancel="['x']"
        >
            <div class="modal-card w-full">
                <header class="modal-card-head bg-white p-4 flex justify-content-between">
                    <button class="button rounded-md border text-gray-800 is-light font-medium tracking-wider is-small"
                            @click="toggleSlider">
                        Close
                    </button>
                    <div>
                        <button class="button rounded-md is-dark font-medium tracking-wider is-small"
                                @click="$emit('apply')">
                            Apply
                        </button>
                        <button class="button rounded-md border text-gray-800 font-medium tracking-wider is-small"
                                @click="$emit('clear')">
                            Clear
                        </button>
                    </div>
                </header>
                <section class="modal-card-body">
                    <slot></slot>
                </section>
            </div>
        </b-sidebar>
    </section>
</template>

<script>
import FilterIcon from "@/components/icons/FilterIcon";

export default {
    components: {FilterIcon},
    data() {
        return {
            checkboxGroup: [],
            open: false
        };
    },
    methods: {
        toggleSlider() {
            this.open = !this.open
        }
    }
};
</script>

<style>
.custom-filter .sidebar-content {
    width: 360px;
    background-color: white;
}
</style>
