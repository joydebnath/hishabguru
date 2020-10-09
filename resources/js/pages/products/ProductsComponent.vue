<template>
    <div class="max-w-6xl m-auto w-full py-2">
        <div class="box pt-6">
            <b-field grouped group-multiline>
                <div class="flex flex-row align-items-center justify-between pb-4 w-full">
                    <template v-if="show_bulk_actions">
                        <div>
                            <b-button size="is-small" type="is-light" class="mr-2">Mark as Inactive</b-button>
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
                        <button class="button field is-info text-sm" @click="handleAdd">
                            <span>New Product</span>
                        </button>
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
                <Table @on-edit="handleEdit" @on-delete="handleDelete"/>
            </keep-alive>
        </div>
        <ItemCRUD
            :show="show_modal"
            :action_type="action_name"
            :item="computed_product"
            :loading="computed_loading"
            @on-close="handleToggleModal"
            @on-loading="handleToggleLoading"
            @on-update="handleUpdateSelectedProduct"
        />
    </div>
</template>

<script>
import {mapGetters, mapMutations} from 'vuex';
import SearchBox from '@/components/global/SearchBox'
import Table from "./ProductTable.vue";
import Filters from "./ProductFilters";
import ItemCRUD from "./modals/ItemCRUD";
import RefreshIcon from "../../components/icons/RefreshIcon";

export default {
    components: {
        RefreshIcon,
        Filters,
        ItemCRUD,
        Table,
        SearchBox,
    },
    data() {
        return {
            show_modal: false,
            action_type: 'add',
            loading: false,
            product: {}
        };
    },
    methods: {
        ...mapMutations({
            setFilters: 'products/setFilters'
        }),
        handleToggleModal() {
            this.show_modal = !this.show_modal;
            this.product = [];
        },
        handleSearch(value) {
            this.setFilters({
                filters: {search: value}
            })
            this.$store.dispatch('products/loadData', {page: 1})
        },
        handleAdd() {
            this.action_type = 'add';
            this.handleToggleModal()
        },
        handleEdit(product) {
            this.action_type = 'edit';
            this.handleToggleModal()
            this.loading = true;
            axios
                .get('/products/' + product.id)
                .then(({data}) => {
                    this.loading = false;
                    this.product = data.data
                })
                .catch(err => {
                    this.loading = false;
                })
        },
        handleDelete(product) {
            this.$buefy.dialog.confirm({
                message: '<h5 class="mb-2 font-medium text-xl">Deleting Product</h5>Are you sure you want to delete <b>' + product.name + '</b> ?',
                confirmText: 'Delete Product',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => {
                    axios
                        .delete('/products/' + product.id)
                        .then(({data}) => {
                            this.$store.dispatch('products/loadData', {
                                page: this.$store.getters['products/getCurrentPage']
                            })
                            this.$buefy.notification.open({
                                message: data.message,
                                type: 'is-success'
                            })
                        })
                        .catch(err => {
                            if (err.response) {
                                this.$buefy.notification.open({
                                    message: err.response.data.message,
                                    type: 'is-danger'
                                })
                            }
                        })
                }
            })
        },
        handleUpdateSelectedProduct(product) {
            this.product = product
        },
        handleToggleLoading(value) {
            this.loading = value
        },
    },
    computed: {
        ...mapGetters({
            checked_products: 'products/getCheckedProducts',
        }),
        show_bulk_actions() {
            return this.checked_products.length
        },
        action_name() {
            return this.action_type
        },
        computed_loading() {
            return this.loading
        },
        computed_product() {
            return this.product
        }
    }
};
</script>
