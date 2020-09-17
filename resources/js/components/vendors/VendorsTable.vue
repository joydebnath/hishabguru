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
            >
                {{ props.row.name }}
                <p class="text-xs text-gray-700"> {{ props.row.formatted_address }} </p>
            </b-table-column>

            <b-table-column
                field="mobile"
                label="Mobile"
                sortable
                v-slot="props"
            >
                {{ props.row.mobile }}
            </b-table-column>

            <b-table-column
                field="email"
                label="Email"
                sortable
                v-slot="props"
            >
                {{ props.row.email }}
            </b-table-column>

<!--            <b-table-column label="Owe You" v-slot="props">-->
<!--                {{ props.row.they_owe_you }}-->
<!--            </b-table-column>-->
            <b-table-column label="You Owe" v-slot="props">
                {{ props.row.you_owe_them }}
            </b-table-column>
            <b-table-column v-slot="props">
                <div class="flex justify-end">
                    <b-tooltip label="View profile" type="is-dark" position="is-bottom">
                        <b-button
                            class="text-lg h-6 w-8 p-4 text-gray-700"
                            icon-right="eye-outline"
                            @click="$emit('on-read',props.row)"
                        />
                    </b-tooltip>
                    &nbsp; &nbsp;
                    <b-tooltip label="Edit supplier" type="is-dark" position="is-bottom">
                        <b-button
                            type="is-info is-light "
                            class="text-lg h-8 w-8  p-4"
                            icon-right="lead-pencil"
                            @click="$emit('on-edit',props.row)"
                        />
                    </b-tooltip>
                    &nbsp; &nbsp;
                    <b-button
                        type="is-danger is-light"
                        class="text-lg h-8 w-8  p-4"
                        icon-right="trash-can-outline"
                        @click="$emit('on-delete', props.row)"
                    />
                </div>
            </b-table-column>
            <template slot="footer">
                <EmptyTable v-if="!data.length"/>
                <div v-else class="has-text-right text-gray-700 font-medium -mb-4 tracking-wider">
                    Total products: {{ total }}
                </div>
            </template>
        </b-table>
    </section>
</template>

<script>
import EmptyTable from '../global/table/EmptyTable'
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
        this.$store.dispatch('suppliers/loadData', {page: 1})
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
