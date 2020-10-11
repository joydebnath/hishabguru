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
                        <router-link to="/@/purchases/create">
                            <button class="button field mr-3 is-info text-sm">
                                <span>New purchase</span>
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
import Table from "./PurchaseTable.vue";
import Filters from "./PurchasesFilters";
import RefreshIcon from "@/components/icons/RefreshIcon";
import DeleteBox from "@/components/global/popups/DeleteBox";
import {remove} from '@/repos/purchases'

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
            tobe_deleted_other_purchase: {}
        };
    },
    methods: {
        handleSearch(value) {
            this.$store.commit('purchases/setFilters', {
                filters: {
                    search: value
                }
            });
            this.$store.dispatch('purchases/loadData', {page: 1})
        },
        handleDelete(purchase_order) {
            this.delete_popup = true;
            this.tobe_deleted_other_purchase = purchase_order;
        },
        handleDeleteClose() {
            this.delete_popup = false;
            this.tobe_deleted_other_purchase = {};
        },
        onConfirmDelete() {
            this.$store.commit('purchases/setLoading', {loading: true})
            remove(this.tobe_deleted_other_purchase.id)
                .then(({data}) => {
                    this.$store.commit('purchases/setLoading', {loading: false})
                    this.$buefy.notification.open({
                        message: data.message,
                        type: 'is-success is-light',
                        duration: 5000
                    });
                    this.$store.dispatch('purchases/loadData', {page: this.current_page});
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
                    this.$store.commit('purchases/setLoading', {loading: false});
                    this.handleDeleteClose();
                })
        }
    },
    computed: {
        ...mapGetters({
            checked_products: 'purchases/getCheckedPurchases',
            current_page: 'purchases/getCurrentPage',
        }),
        show_bulk_actions() {
            return this.checked_products.length
        },
    }
};
</script>
