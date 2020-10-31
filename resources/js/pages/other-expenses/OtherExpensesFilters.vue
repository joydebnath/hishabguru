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
                Amount
            </span>
            <div class="grid grid-cols-2 gap-4">
                <b-field label="From" custom-class="text-xs text-gray-600">
                    <b-numberinput
                        size="is-small"
                        type="is-dark"
                        controls-position="compact"
                        v-model="filters.amount.from"
                    />
                </b-field>
                <b-field label="To" custom-class="text-xs text-gray-600">
                    <b-numberinput
                        size="is-small"
                        type="is-dark"
                        controls-position="compact"
                        v-model="filters.amount.to"
                    />
                </b-field>
            </div>
            <span class="dropdown-divider"></span>
        </template>
        <template>
            <span class="heading font-semibold">
                Total Due
            </span>
            <div class="grid grid-cols-2 gap-4">
                <b-field label="From" custom-class="text-xs text-gray-600">
                    <b-numberinput
                        size="is-small"
                        type="is-dark"
                        controls-position="compact"
                        v-model="filters.due.from"
                    />
                </b-field>
                <b-field label="To" custom-class="text-xs text-gray-600">
                    <b-numberinput
                        size="is-small"
                        type="is-dark"
                        controls-position="compact"
                        v-model="filters.due.to"
                    />
                </b-field>
            </div>
            <span class="dropdown-divider"></span>
        </template>
        <template>
            <span class="heading font-semibold">
                Issued Date
            </span>
            <b-datepicker
                size="is-small"
                custom-class="mb-3"
                placeholder="Click to select date"
                v-model="filters.issue_date"
                range
                extened
                append-to-body
            />
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
    data() {
        return {
            filters: {
                statuses: [],
                amount: {
                    from: null,
                    to: null,
                },
                issue_date: [],
            },
            status_options: [
                {label: 'Due', value: 'due'},
                {label: 'Paid', value: 'paid'},
                {label: 'Draft', value: 'draft'},
            ]
        }
    },
    computed: {
        computed_filters() {
            return this.filters;
        }
    },
    methods: {
        handleApplyFilter() {
            this.$store.commit('other_expenses/setFilters', {filters: this.formattedFilters()})
            this.$store.dispatch('other_expenses/loadData', {page: 1})
        },
        handleClearFilter() {
            this.resetFilters();
            this.$store.commit('other_expenses/setFilters', {filters: {}})
            this.$store.dispatch('other_expenses/loadData', {page: 1})
        },
        resetFilters() {
            this.filters = {
                statuses: [],
                amount: {
                    from: null,
                    to: null,
                },
                due: {
                    from: null,
                    to: null,
                },
                issue_date: [],
                due_date: [],
            }
        },
        formattedFilters() {
            let {issue_date, due_date} = this.filters;
            const formatted_issue_date = _.map(issue_date, value => value.toLocaleDateString());
            const formatted_due_date = _.map(due_date, value => value.toLocaleDateString());
            return  {...this.filters, issue_date: formatted_issue_date, due_date: formatted_due_date}
        }
    }
};
</script>

<style>
.custom-filter .dropdown-item.active, .dropdown-item:active {
    background-color: transparent !important;
}
</style>
