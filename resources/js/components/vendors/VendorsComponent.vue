<template>
    <div class="max-w-6xl m-auto w-full py-2">
        <div class="box pt-6">
            <b-field grouped group-multiline>
                <div class="flex flex-row justify-between pb-4 w-full">
                    <b-field grouped>
                        <SearchBox placeholder="Search by name" @search="handleSearch"/>
                        &nbsp;&nbsp;&nbsp;
                        <Filters />
                    </b-field>
                    <button class="button field is-info" @click="handleAdd">
                        <span>New Supplier</span>
                    </button>
                </div>
            </b-field>
            <div class="border-b my-4"></div>
            <Table @on-edit="handleEdit" @on-delete="handleDelete" @on-read="handleReadProfile"/>
        </div>
        <ItemCRUD
            :show="show_modal"
            :action_type="action_name"
            :item="computed_supplier"
            :loading="computed_loading"
            @on-close="handleToggleModal"
            @on-loading="handleToggleLoading"
        />
        <Profile
            :show="show_profile_modal"
            :loading="computed_loading"
            @on-close="handleToggleProfileModal"
            @on-loading="handleToggleLoading"
        />
    </div>
</template>

<script>
import SearchBox from '../global/SearchBox'
import Table from "./VendorsTable.vue";
import Filters from "./VendorsFilters";
import ItemCRUD from "./modals/ItemCRUD";
import Profile from "./modals/Profile";
import {mapMutations} from "vuex";

export default {
    components: {
        Filters,
        ItemCRUD,
        Table,
        SearchBox,
        Profile
    },
    data() {
        return {
            show_modal: false,
            show_profile_modal: false,
            action_type: 'add',
            loading: false,
            supplier: []
        };
    },
    methods: {
        ...mapMutations({
            setFilters: 'suppliers/setFilters'
        }),
        handleToggleModal() {
            this.show_modal = !this.show_modal;
        },
        handleToggleLoading(){
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
                title: 'Deleting supplier: ' + supplier.name,
                message: 'Are you sure you want to <b>delete</b> the supplier?',
                confirmText: 'Delete supplier',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => {
                    this.$buefy.toast.open('supplier deleted!')
                }
            })
        },
        handleReadProfile(){
            this.handleToggleProfileModal()
        },
        handleToggleProfileModal(){
            this.show_profile_modal = !this.show_profile_modal
        }
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
