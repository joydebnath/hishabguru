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
                        <span>New Product</span>
                    </button>
                </div>
            </b-field>
            <div class="border-b my-4"></div>
            <Table @on-edit="handleEdit" @on-delete="handleDelete" @on-read="handleReadProfile"/>
        </div>
        <ItemCRUD
            :show="show_modal"
            :action_type="action_name"
            :item="computed_product"
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
import {mapMutations} from 'vuex';
import SearchBox from '../global/SearchBox'
import Table from "./MarketplaceTable.vue";
import Filters from "./MarketplaceFilters";
import ItemCRUD from "./modals/ItemCRUD";
import Profile from "./modals/Profile";

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
            product: []
        };
    },
    methods: {
        ...mapMutations({
            setFilters: 'marketplace/setFilters'
        }),
        handleToggleModal() {
            this.show_modal = !this.show_modal;
            this.product = [];
        },
        handleSearch(value) {
            this.setFilters({
                filters: {search: value}
            })
            this.$store.dispatch('marketplace/loadData', {page: 1})
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
                .get('/marketplace/' + product.id)
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
                message: '<h5 class="mb-2 font-medium text-xl">Deleting Product</h5>Are you sure you want to delete <b>'+product.name+'</b> ?',
                confirmText: 'Delete Product',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => {
                    axios
                        .delete('/marketplace/' + product.id)
                        .then(({data}) => {
                            this.$store.dispatch('marketplace/loadData', {
                                page: this.$store.getters['marketplace/getCurrentPage']
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
        },
        handleReadProfile() {
            this.handleToggleProfileModal();
        },
        handleToggleProfileModal() {
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
        computed_product() {
            return this.product
        }
    }
};
</script>
