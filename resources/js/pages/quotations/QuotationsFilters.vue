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
                Created Date
            </span>
            <b-datepicker
                size="is-small"
                custom-class="mb-3"
                placeholder="Click to select date"
                v-model="filters.create_date"
                range
                extened
                append-to-body
            />
            <span class="dropdown-divider"></span>
        </template>
        <template>
            <span class="heading font-semibold">
                Expired Date
            </span>
            <b-datepicker
                size="is-small"
                custom-class="mb-3"
                placeholder="Click to select date"
                v-model="filters.expire_date"
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
                create_date: [],
                expire_date: [],
            },
            status_options: [
                {label: 'Open', value: 'open'},
                {label: 'Accepted', value: 'accepted'},
                {label: 'Declined', value: 'declined'},
                {label: 'Expired', value: 'expired'},
                {label: 'Invoiced', value: 'invoiced'},
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
            this.$store.commit('quotations/setFilters', {filters: this.formattedFilters()})
            this.$store.dispatch('quotations/loadData', {page: 1})
        },
        handleClearFilter() {
            this.resetFilters();
            this.$store.commit('quotations/setFilters', {filters: {}})
            this.$store.dispatch('quotations/loadData', {page: 1})
        },
        resetFilters() {
            this.filters = {
                statuses: [],
                amount: {
                    from: null,
                    to: null,
                },
                create_date: [],
                expire_date: [],
            }
        },
        formattedFilters() {
            let {create_date, expire_date} = this.filters;
            const formatted_create_date = _.map(create_date, value => value.toLocaleDateString());
            const formatted_expire_date = _.map(expire_date, value => value.toLocaleDateString());
            return  {...this.filters, create_date: formatted_create_date, expire_date: formatted_expire_date}
        }
    }
};
</script>

<style>
.custom-filter .dropdown-item.active, .dropdown-item:active {
    background-color: transparent !important;
}
</style>
