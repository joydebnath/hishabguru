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
            default-sort="id"
            backend-sorting
            @sort="onSort"
        >
            <b-table-column
                field="id"
                label="#"
                sortable
                v-slot="props"
            >
                {{ props.row.id }}
            </b-table-column>

            <b-table-column
                field="name"
                label="Category Name"
                sortable
                v-slot="props"
            >
                {{ props.row.name }}
            </b-table-column>

            <b-table-column
                field="parent_category"
                label="Parent Category"
                sortable
                centered
                v-slot="props"
            >
                <span>
                    {{ props.row.parent_category }}
                </span>
            </b-table-column>
            <b-table-column label="Created date" centered v-slot="props">
                <span>
                    {{ props.row.formatted_created_at }}
                </span>
            </b-table-column>

            <b-table-column v-slot="props">
                <div class="flex justify-end">
                    <b-tooltip label="Product category statistics"
                               type="is-dark"
                               position="is-bottom">
                    <b-button
                        type="is-link is-light"
                        class="text-lg h-6 w-8 p-4"
                        icon-right="chart-bar"
                    />
                    </b-tooltip>
                    &nbsp; &nbsp;
                    <b-tooltip label="Edit category"
                               type="is-dark"
                               position="is-bottom">
                    <b-button
                        type="is-info is-light"
                        class="text-lg h-8 w-8  p-4"
                        icon-right="lead-pencil"
                        @click="$emit('on-edit',props.row.id)"
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
            <template slot="footer" >
                <EmptyTable v-if="!data.length"/>
                <div v-else class="has-text-right text-gray-700 font-medium -mb-4 tracking-wider">
                    Total categories: {{total}}
                </div>
            </template>
        </b-table>
    </section>
</template>

<script>
import {mapGetters} from 'vuex'
import EmptyTable from '@/components/global/table/EmptyTable'

export default {
    components: {
        EmptyTable
    },
    mounted() {
        this.$store.dispatch('product_categories/loadData', {page: 1})
    },
    methods: {
        onPageChange(page_no) {
            this.$store.dispatch('product_categories/loadData', {page: page_no})
        },
        onSort(field_name, order) {
            console.log(field_name, order)
        }
    },
    computed: {
        ...mapGetters({
            loading: 'product_categories/getLoading',
            data: 'product_categories/getProductCategories',
            current_page: 'product_categories/getCurrentPage',
            total: 'product_categories/getTotal',
            per_page:'getPerPage'
        })
    }
};
</script>
