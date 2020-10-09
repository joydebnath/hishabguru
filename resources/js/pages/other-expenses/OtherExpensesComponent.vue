<template>
    <div class="max-w-6xl m-auto w-full py-2">
        <div class="box pt-6">
            <b-field grouped group-multiline>
                <div class="flex flex-row justify-between pb-4 w-full">
                    <template v-if="show_bulk_actions">
                        <div>
                            <b-button size="is-small" type="is-danger is-light">Delete</b-button>
                        </div>
                    </template>
                    <template v-else>
                        <b-field grouped>
                            <SearchBox placeholder="Search by Number or Ref." @search="handleSearch"/>
                            &nbsp;&nbsp;&nbsp;
                            <Filters/>
                        </b-field>
                    </template>

                    <section>
                        <router-link to="/@/other-expenses/create">
                            <button class="button field mr-3 is-info text-sm">
                                <span>New expense</span>
                            </button>
                        </router-link>
                        <b-tooltip label="Refresh" type="is-dark" content-class="tracking-wider">
                            <button class="button field text-sm px-2">
                                <RefreshIcon/>
                            </button>
                        </b-tooltip>
                    </section>
                </div>
            </b-field>
            <div class="border-b my-4"></div>
            <keep-alive>
                <Table @on-delete="handleDelete"/>
            </keep-alive>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import SearchBox from '@/components/global/SearchBox';
import Table from "./OtherExpensesTable.vue";
import Filters from "./OtherExpensesFilters";
import RefreshIcon from "../../components/icons/RefreshIcon";

export default {
    components: {
        RefreshIcon,
        Filters,
        Table,
        SearchBox
    },
    data() {
        return {};
    },
    methods: {
        handleSearch(value) {
            this.$store.commit('other_expenses/setFilters', {
                filters: {
                    search: value
                }
            });
            this.$store.dispatch('other_expenses/loadData', {page: 1})
        },
        handleDelete(expense) {
            this.$buefy.dialog.confirm({
                message: '<h5 class="mb-2 font-medium text-xl">Deleting Expense</h5>Are you sure you want to delete the expense: <b>' + expense.expense_number + '</b> ?',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => {
                    this.$store.dispatch('other_expenses/delete', {expense})
                }
            })
        },
    },
    computed: {
        ...mapGetters({
            checked_products: 'other_expenses/getCheckedExpenses'
        }),
        show_bulk_actions() {
            return this.checked_products.length
        },
    }
};
</script>
