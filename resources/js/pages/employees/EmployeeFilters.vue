<template>
    <FilterComponent @apply="handleApplyFilter" @clear="handleClearFilter">
        <template>
            <span class="heading font-semibold">
                Currently working with us
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
                User System Role
            </span>
            <div class="grid grid-cols-2 gaps-4">
                <b-checkbox
                    v-for="option in roles_options"
                    :key="option.value"
                    :native-value="option.value"
                    class="text-sm"
                    v-model="filters.roles"
                >
                    {{ option.label }}
                </b-checkbox>
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
                roles: [],
            },
            status_options: [
                {label: 'Yes', value: 'yes'},
                {label: 'No', value: 'no'},
            ],
            roles_options: [
                {label: 'Admin', value: 'admin'},
                {label: 'Lead Sales Person', value: 'lead-sales'},
                {label: 'Sales Person', value: 'sales'},
            ],
        }
    },
    methods:{
        handleApplyFilter() {
            this.$store.commit('employees/setFilters', {filters: {...this.filters}})
            this.$store.dispatch('employees/loadData', {page: 1})
        },
        handleClearFilter() {
            this.resetFilters();
            this.$store.commit('employees/setFilters', {filters: {}})
            this.$store.dispatch('employees/loadData', {page: 1})
        },
        resetFilters() {
            this.filters = {
                statuses: [],
                roles: []
            }
        },
    }
};
</script>

<style></style>
