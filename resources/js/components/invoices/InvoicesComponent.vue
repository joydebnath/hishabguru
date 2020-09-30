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
                        <span>New Invoice</span>
                    </button>
                </div>
            </b-field>
            <div class="border-b my-4"></div>
            <Table />
        </div>
    </div>
</template>

<script>
import SearchBox from '@/components/global/SearchBox'
import Table from "./InvoicesTable.vue";
import Filters from "./InvoicesFilters";


export default {
    components: {
        Filters,
        Table,
        SearchBox
    },
    data() {
        return {
            show_modal: false
        };
    },
    methods: {
        handleSearch(value){
            console.log(value)
        }
    }
};
</script>
