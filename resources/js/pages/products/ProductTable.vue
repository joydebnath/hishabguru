<template>
    <b-table
        :data="data"
        :paginated="true"
        :per-page="per_page"
        :loading="loading"
        :current-page="current_page"
        :total="total"
        paginated
        pagination-position="bottom"
        backend-pagination
        @page-change="onPageChange"
        default-sort-direction="asc"
        sort-icon="arrow-up"
        sort-icon-size="is-small"
        backend-sorting
        @sort="onSort"
    >
        <b-table-column
            field="code"
            label="Code"
            sortable
            v-slot="props"
            header-class="text-sm"
            cell-class="text-sm"
        >
            {{ props.row.code }}
        </b-table-column>

        <b-table-column
            field="name"
            label="Product Name"
            sortable
            v-slot="props"
            header-class="text-sm"
            cell-class="text-sm"
        >
            {{ props.row.name }}
        </b-table-column>
        <b-table-column
            field="buying_unit_cost"
            label="Buying Cost"
            sortable
            centered
            v-slot="props"
            header-class="text-sm"
            cell-class="text-sm"
        >
            <span>
                {{ props.row.cost }}
            </span>
        </b-table-column>
        <b-table-column
            field="selling_unit_price"
            label="Selling Price"
            sortable
            centered
            v-slot="props"
            header-class="text-sm"
            cell-class="text-sm"
        >
            <span>{{ props.row.sell }}</span>
        </b-table-column>

        <b-table-column
            field="quantity"
            label="Quantity"
            sortable centered
            v-slot="props"
            header-class="text-sm"
            cell-class="text-sm"
        >
            <span>{{ props.row.quantity }}</span>
        </b-table-column>
        <b-table-column label="Category" centered v-slot="props" header-class="text-sm" cell-class="text-sm">
            <span>{{ props.row.category.name }}</span>
        </b-table-column>
        <b-table-column label="Status" centered v-slot="props" header-class="text-sm" cell-class="text-sm">
            <span class="text-capitalize">{{ props.row.status }}</span>
        </b-table-column>
        <b-table-column label="Created" sortable field="created_at" centered v-slot="props" header-class="text-sm" cell-class="text-sm">
            <span class="text-capitalize">{{ props.row.created_at }}</span>
        </b-table-column>
        <b-table-column v-slot="props">
            <div class="flex justify-end">
                <b-dropdown aria-role="list">
                    <b-button class="px-2 rounded" size="is-small" icon-left="dots-vertical text-lg" slot="trigger"/>
                    <b-dropdown-item aria-role="listitem" @click="$emit('on-edit',props.row)">Edit</b-dropdown-item>
                    <router-link :to="'/@/stats/product/' + props.row.id">
                        <b-dropdown-item>
                            View
                        </b-dropdown-item>
                    </router-link>
                    <b-dropdown-item aria-role="listitem" @click="$emit('on-status-update',props.row)">
                        Mark
                        <span v-if="props.row.status === 'active'">Inactive</span>
                        <span v-else>Active</span>
                    </b-dropdown-item>
                    <hr class="dropdown-divider">
                    <b-dropdown-item aria-role="listitem" class="text-red-600" @click="$emit('on-delete', props.row)">
                        Delete
                    </b-dropdown-item>
                </b-dropdown>
            </div>
        </b-table-column>
        <template slot="footer">
            <EmptyTable v-if="!data.length"/>
            <div v-else class="has-text-right text-gray-700 font-medium -mb-4 tracking-wider">
                Total products: {{ total }}
            </div>
        </template>
    </b-table>
</template>

<script>
import {mapGetters} from 'vuex'
import EmptyTable from '@/components/global/table/EmptyTable'

export default {
    components: {
        EmptyTable
    },
    mounted() {
        if (this.data.length === 0) {
            this.$store.dispatch('products/loadData', {page: 1})
        }
    },
    methods: {
        onPageChange(page_no) {
            this.$store.dispatch('products/loadData', {page: page_no})
        },
        onSort(field_name, order) {
            this.$store.commit('products/appendFilter', {
                filters: {
                    sort: {
                        by: field_name,
                        order: order
                    },
                }
            })
            this.$store.dispatch('products/loadData', {page: 1})
        }
    },
    computed: {
        ...mapGetters({
            loading: 'products/getLoading',
            data: 'products/getProducts',
            current_page: 'products/getCurrentPage',
            total: 'products/getTotal',
            per_page: 'getPerPage'
        }),
        checked_products: {
            get() {
                return this.$store.getters['products/getCheckedProducts']
            },
            set(products) {
                this.$store.commit('products/setCheckedProducts', {products: products})
            }
        }
    }
};
</script>
