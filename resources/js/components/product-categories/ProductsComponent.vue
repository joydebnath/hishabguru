<template>
    <div class="max-w-6xl m-auto w-full py-2">
        <div class="box pt-6">
            <b-field grouped group-multiline>
                <div class="flex flex-row justify-between pb-4 w-full">
                    <b-field>
                        <SearchBox placeholder="Search by name" @search="handleSearch"/>
                    </b-field>
                    <button class="button field is-info" @click="handleAdd">
                        <span>New Category</span>
                    </button>
                </div>
            </b-field>
            <div class="border-b my-4"></div>
            <Table @on-edit="handleEdit" @on-delete="handleDelete"/>
        </div>
        <ItemCRUD
            :show="show_modal"
            :action_type="action_name"
            :item="computed_product_category"
            :loading="computed_loading"
            @on-close="handleToggleModal"
            @on-loading="handleToggleLoading"
        />
    </div>
</template>

<script>
import {mapMutations} from "vuex";
import SearchBox from '../global/SearchBox'
import Table from "./ProductTable.vue";
import ItemCRUD from "./modals/ItemCRUD";

export default {
    components: {
        ItemCRUD,
        Table,
        SearchBox
    },
    data() {
        return {
            show_modal: false,
            action_type: 'add',
            loading: false,
            product_category: []
        };
    },
    methods: {
        ...mapMutations({
            setFilters: 'product_categories/setFilters'
        }),
        handleToggleModal() {
            this.show_modal = !this.show_modal;
            this.product_category = [];
        },
        handleSearch(value) {
            this.setFilters({
                filters: {search: value}
            })
            this.$store.dispatch('product_categories/loadData', {page: 1})
        },
        handleAdd() {
            this.action_type = 'add';
            this.handleToggleModal()
        },
        handleEdit(category_id) {
            this.action_type = 'edit';
            this.handleToggleModal()
            this.loading = true;
            axios
                .get('/product-categories/' + category_id)
                .then(({data}) => {
                    this.loading = false;
                    this.product_category = data.data
                })
                .catch(err => {
                    this.loading = false;
                })
        },
        handleDelete(product_category) {
            this.$buefy.dialog.confirm({
                title: 'Deleting product: ' + product_category.name,
                message: 'Are you sure you want to <b>delete</b> the product category?',
                confirmText: 'Delete Category',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => {
                    axios
                        .delete('/product-categories/' + product_category.id)
                        .then(({data}) => {
                            this.$store.dispatch('product_categories/loadData', {
                                page: this.$store.getters['product_categories/getCurrentPage']
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
        handleToggleLoading(value) {
            this.loading = value
        }
    },
    computed: {
        action_name() {
            return this.action_type
        },
        computed_loading() {
            return this.loading
        },
        computed_product_category() {
            return this.product_category
        }
    }
};
</script>
