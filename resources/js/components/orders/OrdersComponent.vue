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
                    <button class="button field is-info" @click="handleToggleModal">
                        <span>New Order</span>
                    </button>
                </div>
            </b-field>
            <div class="border-b my-4"></div>
            <Table />
        </div>
        <ItemCRUD :show="show_modal" @on-close="handleToggleModal" />
    </div>
</template>

<script>
import SearchBox from '../global/SearchBox'
import Table from "./OrdersTable.vue";
import Filters from "./OrdersFilters";
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
        handleSearch(value){
            console.log(value)
        }
    }
};
</script>
