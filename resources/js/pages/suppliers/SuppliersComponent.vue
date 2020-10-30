<template>
    <div class="max-w-6xl m-auto w-full py-2">
        <div class="box pt-6">
            <b-field grouped group-multiline>
                <div class="flex flex-row justify-between pb-4 w-full">
                    <b-field grouped>
                        <SearchBox placeholder="Search by name" @search="handleSearch"/>
                        &nbsp;&nbsp;&nbsp;
                        <Filters/>
                    </b-field>
                    <section>
                        <button class="button field is-info text-sm" @click="handleAdd">
                            <span>New Supplier</span>
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
                <Table @on-edit="handleEdit" @on-delete="handleDelete"/>
            </keep-alive>
        </div>
        <ItemCRUD
            :show="show_modal"
            :action_type="action_name"
            :item="computed_supplier"
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
import {mapMutations, mapGetters} from "vuex";
import SearchBox from '@/components/global/SearchBox'
import RefreshIcon from "@/components/icons/RefreshIcon";
import DeleteBox from "@/components/global/popups/DeleteBox";
import Table from "./SuppliersTable.vue";
import Filters from "./SuppliersFilters";
import ItemCRUD from "./modals/ItemCRUD";

export default {
    components: {
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
            action_type: 'add',
            loading: false,
            supplier: {},
            delete_popup: false,
            tobe_deleted_supplier: {}
        };
    },
    methods: {
        ...mapMutations({
            setFilters: 'suppliers/setFilters'
        }),
        handleToggleModal() {
            this.show_modal = !this.show_modal;
            this.supplier = {};
        },
        handleToggleLoading() {
            this.loading = !this.loading;
        },
        handleSearch(value) {
            this.setFilters({
                filters: {search: value}
            })
            this.$store.dispatch('suppliers/loadData', {page: 1})
        },
        handleRefresh() {
            this.$store.dispatch('suppliers/loadData', {page: this.current_page})
        },
        handleAdd() {
            this.action_type = 'add';
            this.handleToggleModal()
        },
        handleEdit(supplier) {
            this.action_type = 'edit';
            this.handleToggleModal()
            this.loading = true;
            axios
                .get('/suppliers/' + supplier.id)
                .then(({data}) => {
                    this.loading = false;
                    this.supplier = data.data
                })
                .catch(err => {
                    this.loading = false;
                })
        },
        handleDelete(supplier) {
            this.delete_popup = true;
            this.tobe_deleted_supplier = supplier;
        },
        handleDeleteClose() {
            this.delete_popup = false;
            this.tobe_deleted_supplier = {};
        },
        onConfirmDelete() {
            axios
                .delete('/suppliers/' + this.tobe_deleted_supplier.id)
                .then(({data}) => {
                    this.$store.dispatch('suppliers/loadData', {
                        page: this.current_page
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
                        })
                    }
                    ;
                    this.handleDeleteClose();
                })
        }
    },
    computed: {
        ...mapGetters({
            current_page: 'suppliers/getCurrentPage'
        }),
        action_name() {
            return this.action_type
        },
        computed_loading() {
            return this.loading
        },
        computed_supplier() {
            return this.supplier
        }
    }
};
</script>
