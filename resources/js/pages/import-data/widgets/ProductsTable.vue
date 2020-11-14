<template>
    <section class="-mt-2">
        <div style="min-height: 38px">
            <b-button
                class="mb-2"
                size="is-small"
                outlined type="is-danger"
                v-if="checkedRows.length"
                @click="handleDelete"
            >
                Delete
            </b-button>
        </div>
        <b-table
            checkable
            class="import-data-table"
            :data="data"
            :columns="columns"
            :checked-rows.sync="checkedRows"
            :narrowed="true"
            :sticky-header="true"
        >
            <template slot="bottom-left" v-if="checkedRows.length">
                <b>Total checked</b>: {{ checkedRows.length }}
            </template>
        </b-table>
    </section>
</template>

<script>
export default {
    name: "ProductsTable",
    props: {
        data: Array
    },
    data() {
        return {
            columns: [
                {
                    field: 'Name',
                    label: 'Name',
                    sticky: true,
                },
                {
                    field: 'Code',
                    label: 'Code',
                    sticky: true,
                },
                {
                    field: 'Category Name',
                    label: 'Category',
                },
                {
                    field: 'Buying Cost',
                    label: 'Unit Cost',
                },
                {
                    field: 'Selling Price',
                    label: 'Unit Price',
                },
                {
                    field: 'Quantity',
                    label: 'Qty.',
                },
                {
                    field: 'Tax Rate',
                    label: 'Tax',
                },
                {
                    field: 'Do you sell it? (Y/N)',
                    label: 'Is sellable',
                },
                {
                    field: 'Do you buy it? (Y/N)',
                    label: 'Is buyable',
                },
                {
                    field: 'Description',
                    label: 'Desc.',
                },
            ],
            checkedRows: [],
        }
    },
    methods: {
        handleDelete() {
            const end_result = _.filter(this.$props.data, value => {
                return _.findIndex(
                    this.checkedRows,
                    row => (row.uid === value.uid)
                ) === -1
            });
            this.checkedRows = [];
            this.$emit('on-delete', end_result);
        }
    }
}
</script>
