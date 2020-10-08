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
                    <button class="button field is-info" @click="handleAdd">
                        <span>New Supplier</span>
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
            :item="computed_supplier"
            :loading="computed_loading"
            @on-close="handleToggleModal"
            @on-loading="handleToggleLoading"
        />
    </div>
</template>

<script>
import SearchBox from '@/components/global/SearchBox'
import Table from "./VendorsTable.vue";
import Filters from "./VendorsFilters";
import ItemCRUD from "./modals/ItemCRUD";
import {mapMutations} from "vuex";

export default {
    components: {
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
            supplier: {}
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
            this.$buefy.dialog.confirm({
                message: '<h5 class="mb-2 font-medium text-xl">Deleting Supplier</h5>Are you sure you want to delete <b>' + supplier.name + '</b> ?',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => {
                    axios
                        .delete('/suppliers/' + supplier.id)
                        .then(({data}) => {
                            this.$store.dispatch('suppliers/loadData', {
                                page: this.$store.getters['suppliers/getCurrentPage']
                            })
                            this.$buefy.notification.open({
                                message: data.message,
                                type: 'is-success is-light'
                            })
                        })
                        .catch(err => {
                            if (err.response) {
                                this.$buefy.notification.open({
                                    message: err.response.data.message,
                                    type: 'is-danger is-light'
                                })
                            }
                        })
                }
            })
        },
    },
    computed: {
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
