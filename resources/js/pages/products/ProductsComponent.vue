<template>
    <div class="max-w-6xl m-auto w-full py-2">
        <div class="box pt-6">
            <b-field grouped group-multiline>
                <div class="flex flex-row align-items-center justify-between pb-4 w-full">
                    <template v-if="show_bulk_actions">
                        <div>
                            <b-button size="is-small" type="is-light" class="mr-2">Toggle Status</b-button>
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
                            <button class="button field text-sm px-2" @click="handleRefresh">
                                <RefreshIcon/>
                            </button>
                        </b-tooltip>
                    </section>
                </div>
            </b-field>
            <div class="border-b my-4"></div>
            <keep-alive>
                <Table @on-edit="handleEdit" @on-delete="handleDelete" @on-status-update="handleUpdateStatus"/>
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
        <DeleteBox
            :show="delete_popup"
            :handler="onConfirmDelete"
            @on-close="handleDeleteClose"
        />
        <ConfirmationBox
            title="Update Status"
            message="This will change product's status. Are you sure?"
            :show="show_confirm_modal"
            :handler="onConfirmUpdateStatus"
            @on-close="handleUpdateStatusClose"
        />
    </div>
</template>

<script>
import {mapGetters, mapMutations} from 'vuex';
import SearchBox from '@/components/global/SearchBox'
import Table from "./ProductTable.vue";
import Filters from "./ProductFilters";
import ItemCRUD from "./modals/ItemCRUD";
import RefreshIcon from "@/components/icons/RefreshIcon";
import DeleteBox from "@/components/global/popups/DeleteBox";
import ConfirmationBox from "@/components/global/popups/ConfirmationBox";

export default {
    components: {
        ConfirmationBox,
        DeleteBox,
        RefreshIcon,
        Filters,
        ItemCRUD,
        Table,
        SearchBox,
    },
    data() {
        return {
            show_modal: false,
            show_confirm_modal: false,
            action_type: 'add',
            loading: false,
            product: {},
            delete_popup: false,
            tobe_deleted_product: {},
            tobe_updated_product: {},
        };
    },
    methods: {
        ...mapMutations({
            appendFilter: 'products/appendFilter'
        }),
        handleToggleModal() {
            this.show_modal = !this.show_modal;
            this.product = [];
        },
        handleSearch(value) {
            this.appendFilter({
                filters: {search: value}
            })
            this.$store.dispatch('products/loadData', {page: 1})
        },
        handleRefresh() {
            this.$store.dispatch('products/loadData', {page: this.current_page})
        },
        handleAdd() {
            if (this.categories_count === 0) {
                this.noCategoryWarning();
                return;
            }
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
            this.delete_popup = true;
            this.tobe_deleted_product = product;
        },
        handleDeleteClose(product) {
            this.delete_popup = false;
            this.tobe_deleted_product = {};
        },
        onConfirmDelete() {
            axios
                .delete('/products/' + this.tobe_deleted_product.id)
                .then(({data}) => {
                    this.$store.commit('products/remove', {product: this.tobe_deleted_product})
                    this.onSuccess(data.message)
                    this.handleDeleteClose();
                })
                .catch(err => {
                    if (err.response) {
                        this.onError(err.response.data.message)
                        this.handleDeleteClose();
                    }
                })
        },
        handleUpdateSelectedProduct(product) {
            this.product = product
        },
        handleToggleLoading(value) {
            this.loading = value
        },
        handleUpdateStatus(product) {
            this.show_confirm_modal = true;
            this.tobe_updated_product = product;
        },
        handleUpdateStatusClose() {
            this.show_confirm_modal = false;
            this.tobe_updated_product = {};
        },
        onConfirmUpdateStatus() {
            const NEW_STATUS = this.tobe_updated_product.status === 'active' ? 'inactive' : 'active';
            axios
                .patch('/status/products/' + this.tobe_updated_product.id,
                    {status: NEW_STATUS},
                )
                .then(({data}) => {
                    this.$store.commit('products/update', {
                        product: {...this.tobe_updated_product, status: NEW_STATUS}
                    })
                    this.onSuccess(data.message)
                    this.handleUpdateStatusClose()
                })
                .catch(err => {
                    this.onError()
                })
        },
        noCategoryWarning() {
            this.$buefy.snackbar.open({
                message: 'You need to create a product category first',
                type: 'is-warning',
                position: 'is-top',
                actionText: 'Go to',
                indefinite: true,
                onAction: () => {
                    this.$router.push('/@/product-categories');
                }
            })
        },
        onSuccess(message) {
            this.$buefy.notification.open({
                message: message,
                type: 'is-success is-light',
                duration: 5000
            });
        },
        onError(message = 'Whoops! Something went wrong.') {
            this.$buefy.notification.open({
                message: message,
                type: 'is-danger is-light',
                duration: 5000
            });
        }
    },
    computed: {
        ...mapGetters({
            checked_products: 'products/getCheckedProducts',
            current_page: 'products/getCurrentPage',
            categories_count: 'products/getProductCategoriesCount',
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
