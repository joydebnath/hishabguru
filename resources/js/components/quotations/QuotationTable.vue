<template>
    <section class="w-full">
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
            :checked-rows.sync="checked_rows"
            checkable
            default-sort="code"
            backend-sorting
            @sort="onSort"
        >
            <b-table-column
                field="quotation_number"
                label="Number"
                sortable
                v-slot="props"
                cell-class="align-middle"
            >
                {{ props.row.quotation_number }}
            </b-table-column>

            <b-table-column
                field="reference_number"
                label="Ref."
                sortable
                v-slot="props"
                cell-class="align-middle"
            >
                {{ props.row.reference_number }}
            </b-table-column>

            <b-table-column
                field="customer_name"
                label="Client"
                v-slot="props"
                cell-class="align-middle"
            >
                {{ props.row.customer_name }}
            </b-table-column>

            <b-table-column
                field="create_date"
                label="Created"
                sortable
                v-slot="props"
                cell-class="align-middle"
            >
                {{ props.row.create_date }}
            </b-table-column>

            <b-table-column field="expiry_date" sortable label="Expiry" v-slot="props" cell-class="align-middle">
                {{ props.row.expiry_date }}
            </b-table-column>
            <b-table-column field="status" sortable label="Status" centered v-slot="props" cell-class="align-middle">
                <b-tag class="is-light" type="is-success">{{ props.row.status }}</b-tag>
            </b-table-column>
            <b-table-column field="total_amount" sortable label="Amount" centered v-slot="props"
                            cell-class="align-middle">
                {{ props.row.total_amount }}
            </b-table-column>
            <b-table-column v-slot="props" cell-class="align-middle">
                <div class="flex justify-end">
                    <b-tooltip label="Actions" position="is-right" type="is-dark">
                        <b-dropdown aria-role="list">
                            <b-button class="px-2 rounded" size="is-small" icon-left="dots-vertical text-lg"
                                      slot="trigger"/>
                            <b-dropdown-item aria-role="listitem" @click="$emit('on-read',props.row)">
                                View
                            </b-dropdown-item>
                            <b-dropdown-item aria-role="listitem" @click="$emit('on-edit',props.row)">
                                Edit
                            </b-dropdown-item>
                            <b-dropdown-item aria-role="listitem" @click="$emit('on-share', props.row)">
                                Share the link
                            </b-dropdown-item>
                            <hr class="dropdown-divider">
                            <b-dropdown-item aria-role="listitem" @click="$emit('on-delete', props.row)">
                                <span class="text-red-600">Delete</span>
                            </b-dropdown-item>
                        </b-dropdown>
                    </b-tooltip>
                </div>
            </b-table-column>
            <template slot="footer">
                <EmptyTable v-if="!data.length"/>
                <div v-else class="has-text-right text-gray-700 font-medium -mb-4 tracking-wider">
                    Total quotations: {{ total }}
                </div>
            </template>
        </b-table>
    </section>
</template>

<script>
import {mapGetters} from 'vuex'
import EmptyTable from '../global/table/EmptyTable'

export default {
    components: {
        EmptyTable
    },
    mounted() {
        this.$store.dispatch('quotations/loadData', {page: 1})
    },
    methods: {
        onPageChange(page_no) {
            this.$store.dispatch('quotations/loadData', {page: page_no})
        },
        onSort(field_name, order) {
            console.log(field_name, order)
        }
    },
    computed: {
        ...mapGetters({
            loading: 'quotations/getLoading',
            data: 'quotations/getQuotations',
            total: 'quotations/getTotal',
            current_page: 'quotations/getCurrentPage',
            per_page: 'getPerPage'
        }),
        checked_rows: {
            get() {
                return this.$store.getters['quotations/getCheckedQuotations']
            },
            set(value) {
                this.$store.commit('quotations/setCheckedQuotations', {quotations: value})
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
