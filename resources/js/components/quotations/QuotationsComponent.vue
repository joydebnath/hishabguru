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
                    <button class="button field is-info" @click="handleAdd">
                        <span>New Quotation</span>
                    </button>
                </div>
            </b-field>
            <div class="border-b my-4"></div>
            <Table @on-edit="handleEdit" @on-delete="handleDelete" @on-read="handleRead"/>
        </div>
        <ItemCRUD
            :show="show_modal"
            :action_type="action_name"
            :item="computed_quotation"
            :loading="computed_loading"
            @on-close="handleToggleModal"
            @on-loading="handleToggleViewModal"
        />
    </div>
</template>

<script>
import {mapGetters, mapMutations} from 'vuex';
import SearchBox from '../global/SearchBox';
import Table from "./QuotationTable.vue";
import Filters from "./QuotationsFilters";
import ItemCRUD from "./modals/ItemCRUD";
import {read} from './repo/index'

export default {
    components: {
        Filters,
        ItemCRUD,
        Table,
        SearchBox
    },
    data() {
        return {
            show_modal: false,
            loading: false,
            show_view_modal: false,
            action_type: 'add',
            quotation: {}
        };
    },
    methods: {
        handleToggleModal() {
            this.quotation = {};
            this.show_modal = !this.show_modal;
        },
        handleToggleViewModal() {
            this.show_view_modal = !this.show_view_modal
        },
        handleSearch(value) {
            this.$store.commit('quotations/setFilters', {
                filters: {
                    search: value
                }
            });
            this.$store.dispatch('quotations/loadData', {page: 1})
        },
        handleAdd() {
            this.action_type = 'add';
            this.handleToggleModal();
        },
        handleEdit(quotation) {
            this.loading = true;
            this.action_type = 'edit'
            this.handleToggleModal();
            read(quotation.id)
                .then(({data}) => {
                    this.loading = false;
                    this.quotation = data.data
                })
                .catch(err => {
                    this.loading = false;
                    this.handleToggleModal();
                })
        },
        handleDelete(quotation) {
            this.$buefy.dialog.confirm({
                title: 'Deleting quotation',
                message: 'Are you sure you want to delete the quotation: <b>' + quotation.quotation_number + '</b> ?',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => {
                    this.$store.dispatch('quotations/delete', {quotation})
                }
            })

        },
        handleRead(quotation) {
            this.show_view_modal = true
        }
    },
    computed: {
        ...mapGetters({
            checked_products: 'quotations/getCheckedQuotations'
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
        computed_quotation() {
            return this.quotation
        }
    }
};
</script>
