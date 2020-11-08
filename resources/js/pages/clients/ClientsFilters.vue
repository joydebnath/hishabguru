<template>
    <FilterComponent @apply="handleApplyFilter" @clear="handleClearFilter">
        <template>
            <span class="heading font-semibold">
                Status
            </span>
            <div class="grid grid-cols-2 gaps-4">
                <b-checkbox
                    v-for="option in status_options"
                    :key="option.value"
                    :native-value="option.value"
                    class="text-sm"
                    v-model="filters.statuses"
                >
                    {{ option.label }}
                </b-checkbox>
            </div>
            <span class="dropdown-divider"></span>
        </template>
        <template>
            <span class="heading font-semibold">
                Payment Due
            </span>
            <div class="grid grid-cols-2 gap-4">
                <b-field label="From" custom-class="text-xs text-gray-600">
                    <b-numberinput
                        size="is-small"
                        type="is-dark"
                        controls-position="compact"
                        v-model="filters.due_amount.from"
                    />
                </b-field>
                <b-field label="To" custom-class="text-xs text-gray-600">
                    <b-numberinput
                        size="is-small"
                        type="is-dark"
                        controls-position="compact"
                        v-model="filters.due_amount.to"
                    />
                </b-field>
            </div>
            <span class="dropdown-divider"></span>
        </template>
    </FilterComponent>
</template>

<script>
import FilterComponent from "@/components/global/filter/Filter";
export default {
    components: {
        FilterComponent
    },
    data(){
        return {
            filters: {
                statuses: [],
                due_amount: {
                    from: null,
                    to: null,
                },
            },
            status_options: [
                {label: 'Active', value: 'active'},
                {label: 'Inactive', value: 'inactive'},
            ],
        }
    },
    methods:{
        handleApplyFilter() {
            this.$store.commit('clients/setFilters', {filters: {...this.filters}})
            this.$store.dispatch('clients/loadData', {page: 1})
        },
        handleClearFilter() {
            this.resetFilters();
            this.$store.commit('clients/setFilters', {filters: {}})
            this.$store.dispatch('clients/loadData', {page: 1})
        },
        resetFilters() {
            this.filters = {
                statuses: [],
                due_amount: {
                    from: null,
                    to: null,
                },
            }
        },
    }
};
</script>

<style></style>
