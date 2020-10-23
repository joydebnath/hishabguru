<template>
    <section class="w-full">
        <b-table
            :data="data"
            :per-page="per_page"
            :loading="loading"
            :current-page="current_page"
            :total="total"
            :paginated="true"
            paginated
            pagination-position="bottom"
            backend-pagination
            @page-change="onPageChange"
        >
            <b-table-column
                field="order_number"
                label="Number"
                sortable
                v-slot="props"
                cell-class="align-middle text-sm"
                header-class="text-sm"
            >
                {{ props.row.bill_number }}
            </b-table-column>

            <b-table-column
                field="reference_number"
                label="Ref."
                sortable
                v-slot="props"
                cell-class="align-middle text-sm"
                header-class="text-sm"
            >
                {{ props.row.reference_number }}
            </b-table-column>

            <b-table-column
                field="supplier_name"
                label="Supplier"
                v-slot="props"
                cell-class="align-middle text-sm"
                header-class="text-sm"
            >
                {{ props.row.supplier_name }}
            </b-table-column>

            <b-table-column
                field="create_date"
                label="Issued"
                sortable
                v-slot="props"
                cell-class="align-middle text-sm"
                header-class="text-sm"
            >
                {{ props.row.issue_date }}
            </b-table-column>

            <b-table-column field="due_date" sortable label="Due" v-slot="props" cell-class="align-middle text-sm" header-class="text-sm">
                {{ props.row.due_date }}
            </b-table-column>
            <b-table-column field="status" sortable label="Status" centered v-slot="props" cell-class="align-middle text-sm" header-class="text-sm">
                <b-tag class="tracking-wider font-semibold text-uppercase" :type="status_type(props.row.status)">{{ props.row.status }}</b-tag>
            </b-table-column>
            <b-table-column field="total_amount" sortable label="Amount" centered v-slot="props" cell-class="align-middle text-sm" header-class="text-sm">
                {{ props.row.total_amount }}
            </b-table-column>
            <b-table-column v-slot="props" cell-class="align-middle">
                <div class="flex justify-end">
                    <b-dropdown aria-role="list">
                        <b-button class="px-2 rounded" size="is-small" icon-left="dots-vertical text-lg"
                                  slot="trigger"/>
                        <router-link :to="'/@/bills/' + props.row.id">
                            <b-dropdown-item >
                                View
                            </b-dropdown-item>
                        </router-link>
                        <hr class="dropdown-divider">
                        <b-dropdown-item aria-role="listitem" @click="$emit('on-delete', props.row)">
                            <span class="text-red-600">Delete</span>
                        </b-dropdown-item>
                    </b-dropdown>
                </div>
            </b-table-column>
            <template slot="footer">
                <EmptyTable v-if="!data.length"/>
                <div v-else class="has-text-right text-gray-700 font-medium -mb-4 tracking-wider">
                    Total bills: {{ total }}
                </div>
            </template>
        </b-table>
    </section>
</template>

<script>
import {mapGetters} from 'vuex'
import EmptyTable from '@/components/global/table/EmptyTable'

export default {
    components: {
        EmptyTable
    },
    mounted() {
        if(this.data.length === 0) {
            this.$store.dispatch('bills/loadData', {page: 1})
        }
    },
    methods: {
        onPageChange(page_no) {
            this.$store.dispatch('bills/loadData', {page: page_no})
        },
        onSort(field_name, order) {
            console.log(field_name, order)
        },
        status_type(value){
            let type = '';
            switch (value) {
                case 'awaiting-payment':
                    type = 'is-link'
                    break
                case 'paid':
                    type = 'is-success'
                    break;
                case 'due':
                    type = 'is-danger'
                    break;
                case 'draft':
                    type= 'is-light'
                    break
                case 'awaiting-approval':
                    type = 'is-warning'
                    break
            }
            return type
        }
    },
    computed: {
        ...mapGetters({
            loading: 'bills/getLoading',
            data: 'bills/getBills',
            total: 'bills/getTotal',
            current_page: 'bills/getCurrentPage',
            per_page: 'getPerPage'
        }),
        checked_rows: {
            get() {
                return this.$store.getters['bills/getCheckedBills']
            },
            set(value) {
                this.$store.commit('bills/setCheckedBills', {bills: value})
            }
        }
    }
};
</script>

<style>
.table-footer th {
    border-color: transparent !important;
}
</style>
