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
                        <router-link to="/@/orders/create">
                            <button class="button field mr-3 is-info text-sm">
                                <span>New order</span>
                            </button>
                        </router-link>
                        <b-tooltip label="Refresh" type="is-dark" content-class="tracking-wider">
                            <button class="button field text-sm px-2" @click="handleRefresh">
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
import Table from "./OrderTable.vue";
import Filters from "./OrdersFilters";
import RefreshIcon from "@/components/icons/RefreshIcon";
import DeleteBox from "@/components/global/popups/DeleteBox";
import {remove} from '@/repos/orders'

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
            tobe_deleted_order: {}
        };
    },
    methods: {
        handleSearch(value) {
            this.$store.commit('orders/setFilters', {
                filters: {
                    search: value
                }
            });
            this.$store.dispatch('orders/loadData', {page: 1})
        },
        handleRefresh(){
            this.$store.dispatch('orders/loadData', {page: this.current_page})
        },
        handleDelete(order) {
            this.delete_popup = true;
            this.tobe_deleted_order = order;
        },
        handleDeleteClose() {
            this.delete_popup = false;
            this.tobe_deleted_order = {};
        },
        onConfirmDelete(){
            this.$store.commit('orders/setLoading', {loading: true})
            remove(this.tobe_deleted_order.id)
                .then(({data}) => {
                    this.$store.commit('orders/setLoading', {loading: false})
                    this.$buefy.notification.open({
                        message: data.message,
                        type: 'is-success is-light',
                        duration: 5000
                    });
                    this.$store.dispatch('orders/loadData', {page: this.current_page});
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
                    this.$store.commit('orders/setLoading', {loading: false});
                    this.handleDeleteClose();
                })
        }
    },
    computed: {
        ...mapGetters({
            checked_products: 'orders/getCheckedOrders',
            current_page: 'orders/getCurrentPage',
        }),
        show_bulk_actions() {
            return this.checked_products.length
        },
    }
};
</script>
