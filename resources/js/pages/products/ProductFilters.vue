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
                Buying Cost
            </span>
            <div class="grid grid-cols-2 gap-4">
                <b-field label="From" custom-class="text-xs text-gray-600">
                    <b-numberinput
                        size="is-small"
                        type="is-dark"
                        controls-position="compact"
                        v-model="filters.buying_unit_cost.from"
                    />
                </b-field>
                <b-field label="To" custom-class="text-xs text-gray-600">
                    <b-numberinput
                        size="is-small"
                        type="is-dark"
                        controls-position="compact"
                        v-model="filters.buying_unit_cost.to"
                    />
                </b-field>
            </div>
            <span class="dropdown-divider"></span>
        </template>
        <template>
            <span class="heading font-semibold">
                Selling Price
            </span>
            <div class="grid grid-cols-2 gap-4">
                <b-field label="From" custom-class="text-xs text-gray-600">
                    <b-numberinput
                        size="is-small"
                        type="is-dark"
                        controls-position="compact"
                        v-model="filters.selling_unit_cost.from"
                    />
                </b-field>
                <b-field label="To" custom-class="text-xs text-gray-600">
                    <b-numberinput
                        size="is-small"
                        type="is-dark"
                        controls-position="compact"
                        v-model="filters.selling_unit_cost.to"
                    />
                </b-field>
            </div>
            <span class="dropdown-divider"></span>
        </template>
        <template>
            <span class="heading font-semibold">
                Quantity
            </span>
            <div class="grid grid-cols-2 gap-4">
                <b-field label="From" custom-class="text-xs text-gray-600">
                    <b-numberinput
                        size="is-small"
                        type="is-dark"
                        controls-position="compact"
                        v-model="filters.quantity.from"
                    />
                </b-field>
                <b-field label="To" custom-class="text-xs text-gray-600">
                    <b-numberinput
                        size="is-small"
                        type="is-dark"
                        controls-position="compact"
                        v-model="filters.quantity.to"
                    />
                </b-field>
            </div>
            <span class="dropdown-divider"></span>
        </template>
        <template>
            <span class="heading font-semibold">
                Category
            </span>
            <ProductCategory
                size="is-small"
                :name="computed_category.name"
                @on-add="handleAddCategory"
            />
            <span class="dropdown-divider"></span>
        </template>
        <template>
            <span class="heading font-semibold">
                Product is purchasable
            </span>
            <b-radio size="is-small" v-model='filters.is_purchasable' :native-value='true'>Yes</b-radio>
            <b-radio size="is-small" v-model='filters.is_purchasable' :native-value='false'>No</b-radio>
            <span class="dropdown-divider"></span>
        </template>
        <template>
            <span class="heading font-semibold">
                Product is sellable
            </span>
            <b-radio size="is-small" v-model='filters.is_sellable' :native-value='true'>Yes</b-radio>
            <b-radio size="is-small" v-model='filters.is_sellable' :native-value='false'>No</b-radio>
            <span class="dropdown-divider"></span>
        </template>
    </FilterComponent>
</template>

<script>
import FilterComponent from "@/components/global/filter/Filter";
import ProductCategory from "./widgets/ProductCategory";

export default {
    components: {
        ProductCategory,
        FilterComponent
    },
    data() {
        return {
            filters: {
                statuses: [],
                buying_unit_cost: {
                    from: null,
                    to: null,
                },
                selling_unit_cost: {
                    from: null,
                    to: null,
                },
                quantity: {
                    from: null,
                    to: null,
                },
                category: null,
                is_purchasable: true,
                is_sellable: true,
            },
            status_options: [
                {label: 'Active', value: 'active'},
                {label: 'Inactive', value: 'inactive'},
            ],
            category: {}
        }
    },
    computed: {
        computed_category() {
            if (this.category) {
                return {...this.category}
            }
            return {}
        },
    },
    methods: {
        handleApplyFilter() {
            this.$store.commit('products/setFilters', {filters: {...this.filters}})
            this.$store.dispatch('products/loadData', {page: 1})
        },
        handleClearFilter() {
            this.resetFilters();
            this.$store.commit('products/setFilters', {filters: {}})
            this.$store.dispatch('products/loadData', {page: 1})
        },
        resetFilters() {
            this.filters = {
                statuses: [],
                buying_unit_cost: {
                    from: null,
                    to: null,
                },
                selling_unit_cost: {
                    from: null,
                    to: null,
                },
                quantity: {
                    from: null,
                    to: null,
                },
                category: null,
                is_purchasable: true,
                is_sellable: true,
            }
        },
        handleAddCategory(category) {
            if (category) {
                this.filters = {...this.filters, category: category.id}
                return 0;
            }
            this.filters = {...this.filters, category: null}
        },
    }
};
</script>

<style></style>
