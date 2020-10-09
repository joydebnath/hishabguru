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
                            <SearchBox placeholder="Search by name" @search="handleSearch"/>
                            &nbsp;&nbsp;&nbsp;
                            <Filters/>
                        </b-field>
                    </template>
                    <section>
                        <router-link to="/@/bills/create">
                            <button class="button mr-3 field is-info text-sm">
                                <span>New Bill</span>
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
import Table from "./BillsTable.vue";
import Filters from "./BillsFilters";
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
            this.$store.commit('bills/setFilters', {
                filters: {
                    search: value
                }
            });
            this.$store.dispatch('bills/loadData', {page: 1})
        },
        handleDelete(bill) {
            this.$buefy.dialog.confirm({
                message: '<h5 class="mb-2 font-medium text-xl">Deleting Bill</h5>Are you sure you want to delete <b>' + bill.bill_number + '</b> ?',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => {
                    this.$store.dispatch('bills/delete', {bill})
                }
            })
        },
    },
    computed: {
        ...mapGetters({
            checked_products: 'bills/getCheckedBills'
        }),
        show_bulk_actions() {
            return this.checked_products.length
        },
    }
};
</script>
