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
        <DeleteBox
            :show="delete_popup"
            :handler="onConfirmDelete"
            @on-close="handleDeleteClose"
        />
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import SearchBox from '@/components/global/SearchBox';
import Table from "./BillsTable.vue";
import Filters from "./BillsFilters";
import RefreshIcon from "@/components/icons/RefreshIcon";
import DeleteBox from "@/components/global/popups/DeleteBox";
import {remove} from '@/repos/bills'

export default {
    components: {
        DeleteBox,
        RefreshIcon,
        Filters,
        Table,
        SearchBox
    },
    data() {
        return {
            delete_popup: false,
            tobe_deleted_bill: {}
        };
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
            this.delete_popup = true;
            this.tobe_deleted_bill = bill;
        },
        handleDeleteClose() {
            this.delete_popup = false;
            this.tobe_deleted_bill = {};
        },
        onConfirmDelete() {
            this.$store.commit('bills/setLoading', {loading: true});
            remove(this.tobe_deleted_bill.id)
                .then(({data}) => {
                    this.$store.commit('bills/setLoading', {loading: false})
                    this.$buefy.notification.open({
                        message: data.message,
                        type: 'is-success is-light',
                        duration: 5000
                    });
                    this.$store.dispatch('bills/loadData', {page: this.current_page});
                    this.handleDeleteClose();
                })
                .catch(err => {
                    console.log(err)
                    if (err.response) {
                        this.$buefy.notification.open({
                            message: err.response.data.message,
                            type: 'is-danger is-light',
                            duration: 5000
                        })
                    }
                    this.$store.commit('bills/setLoading', {loading: false});
                    this.handleDeleteClose();
                })
        }
    },
    computed: {
        ...mapGetters({
            checked_products: 'bills/getCheckedBills',
            current_page: 'bills/getCurrentPage',
        }),
        show_bulk_actions() {
            return this.checked_products.length
        },
    }
};
</script>
