<template>
    <section class="-mt-2">
        <div style="min-height: 38px">
            <b-button class="mb-2" size="is-small" outlined type="is-danger" v-if="checkedRows.length">Delete</b-button>
        </div>
        <b-table
            checkable
            custom-class="text-sm"
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
    name: "SuppliersTable",
    props: {
        data: Array
    },
    data() {
        return {
            columns: [
                {
                    field: 'Company Name',
                    label: 'Company',
                    sticky: true,
                },
                {
                    field: 'Mobile',
                    label: 'Mobile',
                },
                {
                    field: 'Phone',
                    label: 'Phone',
                },
                {
                    field: 'Email',
                    label: 'Email',
                },
                {
                    field: 'Contact Address',
                    label: 'Address',
                },
                {
                    field: 'City',
                    label: 'City',
                },
                {
                    field: 'Postcode',
                    label: 'Postcode',
                },
                {
                    field: 'State/Division',
                    label: 'State',
                },
                {
                    field: 'Country',
                    label: 'Country',
                },
                {
                    field: 'Note',
                    label: 'Note',
                },
                {
                    field: 'Contact Person Name',
                    label: 'Contact Person Name',
                },
                {
                    field: 'Contact Person Mobile',
                    label: 'Contact Person Mobile',
                },
                {
                    field: 'Contact Person Email',
                    label: 'Contact Person Email',
                },
            ],
            checkedRows: [],
        }
    }
}
</script>
