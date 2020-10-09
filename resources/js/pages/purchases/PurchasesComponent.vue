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
                    <router-link to="/@/purchases/create">
                        <button class="button field is-info text-sm">
                            <span>New purchase</span>
                        </button>
                    </router-link>
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
import Table from "./PurchaseTable.vue";
import Filters from "./PurchasesFilters";

export default {
    components: {
        Filters,
        Table,
        SearchBox
    },
    data() {
        return {};
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
            this.$buefy.dialog.confirm({
                message: '<h5 class="mb-2 font-medium text-xl">Deleting Purchase Order</h5>Are you sure you want to delete the purchase order: <b>' + purchase_order.purchase_order_number + '</b> ?',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => {
                    this.$store.dispatch('purchases/delete', {purchase_order})
                }
            })
        },
    },
    computed: {
        ...mapGetters({
            checked_products: 'purchases/getCheckedPurchases'
        }),
        show_bulk_actions() {
            return this.checked_products.length
        },
    }
};
</script>
