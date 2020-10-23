<template>
    <section class="w-full">
        <b-table
            :data="data"
            :paginated="true"
            :per-page="per_page"
            :loading="loading"
            paginated
            backend-pagination
            :total="total"
            @page-change="onPageChange"

            :current-page="current_page"
            pagination-position="bottom"
            default-sort-direction="asc"
            sort-icon="arrow-up"
            sort-icon-size="is-small"
            :checked-rows.sync="checkedRows"
            checkable
            default-sort="code"
            backend-sorting
            @sort="onSort"
        >
            <b-table-column
                field="name"
                label="Name"
                sortable
                v-slot="props"
                header-class="text-sm"
                cell-class="text-sm"
            >
                {{ props.row.name }}
                <p class="text-xs text-gray-700"> {{ props.row.formatted_address }} </p>
            </b-table-column>

            <b-table-column
                field="mobile"
                label="Mobile"
                sortable
                v-slot="props"
                header-class="text-sm"
                cell-class="text-sm"
            >
                {{ props.row.mobile }}
            </b-table-column>

            <b-table-column
                field="email"
                label="Email"
                sortable
                v-slot="props"
                header-class="text-sm"
                cell-class="text-sm"
            >
                {{ props.row.email }}
            </b-table-column>
            <b-table-column label="You Owe" v-slot="props" header-class="text-sm" cell-class="text-sm">
                {{ props.row.you_owe_them }}
            </b-table-column>
            <b-table-column v-slot="props" header-class="text-sm">
                <div class="flex justify-end">
                    <b-dropdown aria-role="list">
                        <b-button class="px-2 rounded" size="is-small" icon-left="dots-vertical text-lg" slot="trigger"/>
                        <b-dropdown-item aria-role="listitem" @click="$emit('on-edit',props.row)">Edit</b-dropdown-item>
                        <hr class="dropdown-divider">
                        <b-dropdown-item aria-role="listitem" class="text-red-600"
                                         @click="$emit('on-delete', props.row)">Delete
                        </b-dropdown-item>
                    </b-dropdown>
                </div>
            </b-table-column>
            <template slot="footer">
                <EmptyTable v-if="!data.length"/>
                <div v-else class="has-text-right text-gray-700 font-medium -mb-4 tracking-wider">
                    Total suppliers: {{ total }}
                </div>
            </template>
        </b-table>
    </section>
</template>

<script>
import EmptyTable from '@/components/global/table/EmptyTable'
import {mapGetters} from "vuex";

export default {
    components: {
        EmptyTable
    },
    data() {
        return {
            checkedRows: []
        };
    },
    mounted() {
        if(this.data.length === 0) {
            this.$store.dispatch('suppliers/loadData', {page: 1})
        }
    },
    methods: {
        onPageChange(page_no) {
            this.$store.dispatch('suppliers/loadData', {page: page_no})
        },
        onSort(field_name, order) {
            console.log(field_name, order)
        }
    },
    computed: {
        ...mapGetters({
            loading: 'suppliers/getLoading',
            data: 'suppliers/getSuppliers',
            current_page: 'suppliers/getCurrentPage',
            total: 'suppliers/getTotal',
            per_page: 'getPerPage'
        })
    }
};
</script>

<style>
.table-footer th {
    border-color: transparent !important;
}
</style>
