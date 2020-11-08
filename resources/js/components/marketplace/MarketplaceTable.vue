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

        :checked-rows.sync="checkedRows"
        checkable
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
        >
            {{ props.row.code }}
        </b-table-column>

        <b-table-column
            field="name"
            label="Product Name"
            sortable
            v-slot="props"
        >
            {{ props.row.name }}
        </b-table-column>
        <b-table-column
            field="buying_cost"
            label="Buying Cost"
            sortable
            centered
            v-slot="props"
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
        >
                <span>
                    {{ props.row.sell }}
                </span>
        </b-table-column>

        <b-table-column label="Quantity" centered v-slot="props">
                <span>
                    {{ props.row.quantity }}
                </span>
        </b-table-column>
        <b-table-column label="Category" centered v-slot="props">
                <span>
                    {{ props.row.category }}
                </span>
        </b-table-column>
        <b-table-column v-slot="props">
            <div class="flex justify-end">
                <b-tooltip label="Product statistics"
                           type="is-dark"
                           position="is-bottom">
                    <b-button
                        type="is-link is-light"
                        class="text-lg h-6 w-8 p-4 "
                        icon-right="chart-bar"
                        @click="$emit('on-read',props.row)"
                    />
                </b-tooltip>
                &nbsp; &nbsp;
                <b-tooltip label="Edit product"
                           type="is-dark"
                           position="is-bottom">
                    <b-button
                        type="is-info is-light"
                        class="text-lg h-8 w-8  p-4 "
                        icon-right="lead-pencil"
                        @click="$emit('on-edit',props.row)"
                    />
                </b-tooltip>
                &nbsp; &nbsp;
                <b-tooltip label="Add product image"
                           type="is-dark"
                           position="is-bottom">
                    <b-button icon-right="camera-plus" class="text-lg h-8 w-8  p-4 text-gray-700"/>
                </b-tooltip>
                &nbsp; &nbsp;
                <b-button
                    type="is-danger is-light"
                    class="text-lg h-8 w-8  p-4"
                    icon-right="trash-can-outline"
                    @click="$emit('on-delete', props.row)"
                />
            </div>
        </b-table-column>
        <template slot="footer" >
            <EmptyTable v-if="!data.length"/>
            <div v-else class="has-text-right text-gray-700 font-medium -mb-4 tracking-wider">
                Total products: {{total}}
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
    data() {
        return {
            checkedRows: []
        };
    },
    mounted() {
        this.$store.dispatch('marketplace/loadData', {page: 1})
    },
    methods: {
        onPageChange(page_no) {
            this.$store.dispatch('marketplace/loadData', {page: page_no})
        },
        onSort(field_name, order) {
            console.log(field_name, order)
        }
    },
    computed: {
        ...mapGetters({
            loading: 'marketplace/getLoading',
            data: 'marketplace/getProducts',
            current_page: 'marketplace/getCurrentPage',
            total: 'marketplace/getTotal',
            per_page:'getPerPage'
        })
    }
};
</script>
