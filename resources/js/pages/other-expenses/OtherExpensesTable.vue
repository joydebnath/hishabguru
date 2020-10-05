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
                field="expense_number"
                label="Number"
                sortable
                v-slot="props"
                cell-class="align-middle"
            >
                {{ props.row.expense_number }}
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
                field="issue_date"
                label="Issued"
                sortable
                v-slot="props"
                cell-class="align-middle"
            >
                {{ props.row.issue_date }}
            </b-table-column>

            <b-table-column field="due_date" sortable label="Due" v-slot="props" cell-class="align-middle">
                {{ props.row.due_date }}
            </b-table-column>
            <b-table-column field="status" sortable label="Status" centered v-slot="props" cell-class="align-middle">
                <b-tag class="tracking-wider font-semibold text-uppercase" :type="status_type(props.row.status)">{{ props.row.status }}</b-tag>
            </b-table-column>
            <b-table-column field="total_amount" sortable label="Amount" centered v-slot="props" cell-class="align-middle">
                {{ props.row.total_amount }}
            </b-table-column>
            <b-table-column field="total_amount" sortable label="Remaining" centered v-slot="props" cell-class="align-middle">
                {{ props.row.total_due }}
            </b-table-column>
            <b-table-column v-slot="props" cell-class="align-middle">
                <div class="flex justify-end">
                    <b-tooltip label="Actions" position="is-right" type="is-dark">
                        <b-dropdown aria-role="list">
                            <b-button class="px-2 rounded" size="is-small" icon-left="dots-vertical text-lg"
                                      slot="trigger"/>
                            <router-link :to="'/@/other-expenses/' + props.row.id">
                                <b-dropdown-item >
                                    View
                                </b-dropdown-item>
                            </router-link>
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
                    Total expenses: {{ total }}
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
        this.$store.dispatch('other_expenses/loadData', {page: 1})
    },
    methods: {
        onPageChange(page_no) {
            this.$store.dispatch('other_expenses/loadData', {page: page_no})
        },
        onSort(field_name, order) {
            console.log(field_name, order)
        },
        status_type(value){
            const STATUS_MAP = {
                'paid': 'is-success',
                'due': 'is-danger',
                'draft': 'is-light',
                'save-for-approval': 'is-warning'
            }
            return STATUS_MAP[value];
        }
    },
    computed: {
        ...mapGetters({
            loading: 'other_expenses/getLoading',
            data: 'other_expenses/getExpenses',
            total: 'other_expenses/getTotal',
            current_page: 'other_expenses/getCurrentPage',
            per_page: 'getPerPage'
        }),
        checked_rows: {
            get() {
                return this.$store.getters['other_expenses/getCheckedExpenses']
            },
            set(value) {
                this.$store.commit('other_expenses/setCheckedExpenses', {expenses: value})
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
