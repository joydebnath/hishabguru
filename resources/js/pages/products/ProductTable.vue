<template>
    <b-table
        :data="data"
        :paginated="true"
        :per-page="per_page"
        :loading="loading"
        paginated
        backend-pagination
        :total="total"
        @page-change="onPageChange"

        :current-page="current_page"
        pagination-position="bottom"
        default-sort-direction="asc"
        sort-icon="arrow-up"
        sort-icon-size="is-small"
        :checked-rows.sync="checked_products"
        checkable
        default-sort="code"
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
            field="buying_cost"
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
            field="selling_price"
            label="Sale Price"
            sortable
            centered
            v-slot="props"
            header-class="text-sm"
            cell-class="text-sm"
        >
                <span>
                    {{ props.row.sell }}
                </span>
        </b-table-column>

        <b-table-column label="Quantity" centered v-slot="props" header-class="text-sm" cell-class="text-sm">
                <span>
                    {{ props.row.quantity }}
                </span>
        </b-table-column>
        <b-table-column label="Category" centered v-slot="props" header-class="text-sm" cell-class="text-sm">
                <span>
                    {{ props.row.category.name }}
                </span>
        </b-table-column>
        <b-table-column v-slot="props">
            <div class="flex justify-end">
                <b-dropdown aria-role="list">
                    <b-button class="px-2 rounded" size="is-small" icon-left="dots-vertical text-lg" slot="trigger"/>
                    <b-dropdown-item aria-role="listitem" @click="$emit('on-edit',props.row)">Edit</b-dropdown-item>
<!--                    <b-dropdown-item aria-role="listitem" @click="$emit('on-edit',props.row)">Mark Inactive</b-dropdown-item>-->
                    <hr class="dropdown-divider">
                    <b-dropdown-item aria-role="listitem" class="text-red-600" @click="$emit('on-delete', props.row)">Delete</b-dropdown-item>
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
        this.$store.dispatch('products/loadData', {page: 1})
    },
    methods: {
        onPageChange(page_no) {
            this.$store.dispatch('products/loadData', {page: page_no})
        },
        onSort(field_name, order) {
            console.log(field_name, order)
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
