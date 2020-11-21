<template>
    <section class="w-full">
        <b-table
            :data="data"
            :paginated="true"
            :per-page="per_page"
            :loading="loading"
            :current-page="current_page"
            :total="total"
            paginated
            pagination-position="bottom"
            backend-pagination
            @page-change="onPageChange"

            default-sort-direction="asc"
            sort-icon="arrow-up"
            sort-icon-size="is-small"
            backend-sorting
            @sort="onSort"
        >
            <b-table-column
                field="name"
                label="Name"
                v-slot="props"
                header-class="text-sm"
                cell-class="text-sm"
            >
                {{ props.row.name }}
                <p class="text-xs text-gray-700"> {{ props.row.formatted_address }} </p>
            </b-table-column>
            <b-table-column label="Job Title" v-slot="props" header-class="text-sm">
                {{ props.row.job_title }}
            </b-table-column>
            <b-table-column
                field="mobile"
                label="Mobile"
                v-slot="props"
                header-class="text-sm"
                cell-class="text-sm"
            >
                {{ props.row.mobile }}
            </b-table-column>

            <b-table-column
                field="email"
                label="Email"
                v-slot="props"
                header-class="text-sm"
                cell-class="text-sm"
            >
                {{ props.row.email }}
            </b-table-column>

            <b-table-column label="Is Active" v-slot="props" header-class="text-sm" cell-class="text-sm">
                {{ props.row.currently_working }}
            </b-table-column>

            <b-table-column label="Created" sortable field="created_at" v-slot="props" header-class="text-sm" cell-class="text-sm">
                {{ props.row.created_at }}
            </b-table-column>

            <b-table-column v-slot="props">
                <div class="flex justify-end">
                    <b-dropdown aria-role="list">
                        <b-button class="px-2 rounded" size="is-small" icon-left="dots-vertical text-lg"
                                  slot="trigger"/>
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
                    Total employees: {{ total }}
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
            this.$store.dispatch('employees/loadData', {page: 1})
        }
    },
    methods: {
        onPageChange(page_no) {
            this.$store.dispatch('employees/loadData', {page: page_no})
        },
        onSort(field_name, order) {
            this.$store.commit('employees/appendFilter', {
                filters: {
                    sort: {
                        by: field_name,
                        order: order
                    },
                }
            })
            this.$nextTick(() => {
                this.$store.dispatch('employees/loadData', {page: 1})
            })
        },
    },
    computed: {
        ...mapGetters({
            loading: 'employees/getLoading',
            data: 'employees/getEmployees',
            current_page: 'employees/getCurrentPage',
            total: 'employees/getTotal',
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
