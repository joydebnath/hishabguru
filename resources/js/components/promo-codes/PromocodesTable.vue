<template>
    <section class="w-full">
        <b-table
            :data="data"
            :paginated="isPaginated"
            :per-page="15"
            :current-page="currentPage"
            :pagination-position="paginationPosition"
            :default-sort-direction="defaultSortDirection"
            :sort-icon="sortIcon"
            :sort-icon-size="sortIconSize"

            aria-next-label="Next page"
            aria-previous-label="Previous page"
            aria-page-label="Page"
            aria-current-label="Current page"

            default-sort-direction="asc"
            sort-icon="arrow-up"
            sort-icon-size="is-small"
            :checked-rows.sync="checked_rows"
            checkable
            default-sort="user.first_name"
            backend-sorting
            @sort="{}"
        >
            <b-table-column
                field="id"
                label="Code"
                width="40"
                sortable
                numeric
                v-slot="props"
            >
                {{ props.row.id }}
            </b-table-column>

            <b-table-column
                field="user.first_name"
                label="Product Name"
                sortable
                v-slot="props"
            >
                {{ props.row.user.first_name }}
            </b-table-column>

            <b-table-column
                field="user.last_name"
                label="Cost Price"
                sortable
                v-slot="props"
            >
                {{ props.row.user.last_name }}
            </b-table-column>

            <b-table-column
                field="date"
                label="Sale Price"
                sortable
                centered
                v-slot="props"
            >
                <span>
                    {{ new Date(props.row.date).toLocaleDateString() }}
                </span>
            </b-table-column>

            <b-table-column label="Quantity" v-slot="props">
                <span>
                    {{ props.row.gender }}
                </span>
            </b-table-column>
            <b-table-column label="Type" v-slot="props">
                <span>
                    {{ props.row.gender }}
                </span>
            </b-table-column>
            <b-table-column>
                <div class="flex justify-end">
                    <b-button
                        class="text-lg h-6 w-8 p-4 text-gray-700"
                        icon-right="eye-outline"
                    />
                    &nbsp; &nbsp;
                    <b-button
                        type="is-info is-light "
                        class="text-lg h-8 w-8  p-4"
                        icon-right="lead-pencil"
                    />
                    &nbsp; &nbsp;
                    <b-button
                        type="is-danger is-light"
                        class="text-lg h-8 w-8  p-4"
                        icon-right="trash-can-outline"
                    />
                </div>
            </b-table-column>
            <template slot="footer" v-if="!data.length">
                <EmptyTable />
            </template>
        </b-table>
    </section>
</template>

<script>
import EmptyTable from '@/components/global/table/EmptyTable'
export default {
    components:{
        EmptyTable
    },
    data() {
        return {
            data: [
                {
                    id: 1,
                    user: { first_name: "Joy", last_name: "Debnath" },
                    date: "2020-03-28",
                    gender: "male"
                }
            ],
            isPaginated: true,
            paginationPosition: "bottom",
            defaultSortDirection: "asc",
            sortIcon: "arrow-up",
            sortIconSize: "is-small",
            currentPage: 1,
            checked_rows: []
        };
    }
};
</script>

<style>
.table-footer th{
    border-color: transparent !important;
}
</style>
