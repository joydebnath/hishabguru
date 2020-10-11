<template>
    <div class="max-w-6xl m-auto w-full py-2">
        <div class="box pt-6">
            <b-field grouped group-multiline>
                <div class="flex flex-row justify-between pb-4 w-full">
                    <b-field>
                        <SearchBox placeholder="Search by name" @search="handleSearch"/>
                    </b-field>
                    <button class="button field is-info text-sm" @click="handleAdd">
                        <span>New Category</span>
                    </button>
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
            :item="computed_product_category"
            :loading="computed_loading"
            @on-close="handleToggleModal"
            @on-loading="handleToggleLoading"
        />
        <DeleteBox
            :show="delete_popup"
            :handler="onConfirmDelete"
            @on-close="handleDeleteClose"
        />
    </div>
</template>

<script>
import {mapMutations} from "vuex";
import SearchBox from '@/components/global/SearchBox'
import Table from "./ProductTable.vue";
import ItemCRUD from "./modals/ItemCRUD";
import DeleteBox from "@/components/global/popups/DeleteBox";

export default {
    components: {
        DeleteBox,
        ItemCRUD,
        Table,
        SearchBox
    },
    data() {
        return {
            show_modal: false,
            action_type: 'add',
            loading: false,
            product_category: [],
            delete_popup: false,
            tobe_deleted_product_category: {}
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
            this.delete_popup = true;
            this.tobe_deleted_product_category = product_category;
        },
        handleDeleteClose(product_category) {
            this.delete_popup = false;
            this.tobe_deleted_product_category = {};
        },
        onConfirmDelete(){
            axios
                .delete('/product-categories/' + this.tobe_deleted_product_category.id)
                .then(({data}) => {
                    this.$store.dispatch('product_categories/loadData', {
                        page: this.$store.getters['product_categories/getCurrentPage']
                    })
                    this.$buefy.notification.open({
                        message: data.message,
                        type: 'is-success is-light',
                        duration: 5000
                    });
                    this.handleDeleteClose();
                })
                .catch(err => {
                    if (err.response) {
                        this.$buefy.notification.open({
                            message: err.response.data.message,
                            type: 'is-danger is-light',
                            duration: 5000
                        });
                        this.handleDeleteClose();
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
