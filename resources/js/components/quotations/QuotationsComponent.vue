<template>
    <div class="max-w-6xl m-auto w-full py-2">
        <div class="box pt-6">
            <b-field grouped group-multiline>
                <div class="flex flex-row justify-between pb-4 w-full">
                    <template v-if="show_bulk_actions">
                        <div>
                            <!--                            <b-button size="is-small" type="is-light" class="mr-2">Mark as Inactive</b-button>-->
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
                    <button class="button field is-info" @click="handleToggleModal">
                        <span>New Quotation</span>
                    </button>
                </div>
            </b-field>
            <div class="border-b my-4"></div>
            <Table/>
        </div>
        <ItemCRUD :show="show_modal" @on-close="handleToggleModal"/>
    </div>
</template>

<script>
import {mapGetters, mapMutations} from 'vuex';
import SearchBox from '../global/SearchBox';
import Table from "./QuotationTable.vue";
import Filters from "./QuotationsFilters";
import ItemCRUD from "./modals/ItemCRUD";

export default {
    components: {
        Filters,
        ItemCRUD,
        Table,
        SearchBox
    },
    data() {
        return {
            show_modal: false
        };
    },
    methods: {
        handleToggleModal() {
            this.show_modal = !this.show_modal;
        },
        handleSearch(value) {
            this.$store.commit('quotations/setFilters', {
                filters: {
                    search: value
                }
            });
            this.$store.dispatch('quotations/loadData', {page: 1})
        }
    },
    computed: {
        ...mapGetters({
            checked_products: 'quotations/getCheckedQuotations'
        }),
        show_bulk_actions() {
            return this.checked_products.length
        },
    }
};
</script>
