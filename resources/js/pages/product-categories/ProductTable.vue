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
        >
            <b-table-column
                field="id"
                label="#"
                sortable
                v-slot="props"
                header-class="text-sm"
            >
                {{ props.row.id }}
            </b-table-column>

            <b-table-column
                field="name"
                label="Category Name"
                sortable
                v-slot="props"
                header-class="text-sm"
            >
                {{ props.row.name }}
            </b-table-column>

            <b-table-column
                field="note"
                label="Note"
                sortable
                v-slot="props"
                header-class="text-sm"
            >
                <span>
                    {{ props.row.note }}
                </span>
            </b-table-column>
            <b-table-column label="Created date" centered v-slot="props" header-class="text-sm">
                <span>
                    {{ props.row.formatted_created_at }}
                </span>
            </b-table-column>

            <b-table-column v-slot="props" >
                <div class="flex justify-end">
                    <b-dropdown aria-role="list">
                        <b-button class="px-2 rounded" size="is-small" icon-left="dots-vertical text-lg" slot="trigger"/>
<!--                        <b-dropdown-item aria-role="listitem" @click="$emit('on-read',props.row)">Statistics</b-dropdown-item>-->
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
                    Total categories: {{ total }}
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
        if(this.data.length === 0) {
            this.$store.dispatch('product_categories/loadData', {page: 1})
        }
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
            per_page: 'getPerPage'
        })
    }
};
</script>
