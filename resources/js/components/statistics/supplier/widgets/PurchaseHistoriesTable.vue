<template>
    <div class="box mt-6 p-4">
        <label class="heading text-lg">Purchase Histories</label>
        <div class="flex flex-row-reverse mb-2">
            <b-field custom-class="trans_his">
                <b-datepicker
                    v-model="date"
                    type="month"
                    custom-class="is-small"
                    placeholder="Select Month/Year"
                />
                <b-button
                    class="is-small rounded"
                    @click="handleFilterHistories"
                    icon-pack="fa"
                    icon-left="fas fa-paper-plane"
                    type="is-dark"
                />
            </b-field>
        </div>
        <b-table :data="histories" :columns="columns" class="text-sm"/>
    </div>
</template>

<script>
export default {
    name: "PurchaseHistoriesTable",
    props: {
        supplier_id: String
    },
    mounted() {
        if (this.$props.supplier_id) {
            axios
                .get(`/supplier-statistics/${this.$props.supplier_id}/paid-invoices`)
                .then(({data}) => {

                })
                .catch(err => {

                })
        }
    },
    data() {
        return {
            date: null,
            histories: [
                {
                    'date': '2016-10-15 13:43:27',
                    'type': 'Bill',
                    'number': 'BIL-001',
                    'quantity': '3',
                    'unit_price': '1900',
                    'total': '5700',
                },
                {
                    'date': '2016-10-15 13:43:27',
                    'type': 'Bill',
                    'number': 'BIL-002',
                    'quantity': '3',
                    'unit_price': '1900',
                    'total': '5700',
                },
                {
                    'date': '2016-10-15 13:43:27',
                    'type': 'Bill',
                    'number': 'BIL-003',
                    'quantity': '3',
                    'unit_price': '1900',
                    'total': '5700',
                },
                {
                    'date': '2016-10-15 13:43:27',
                    'type': 'Bill',
                    'number': 'BIL-004',
                    'quantity': '3',
                    'unit_price': '1900',
                    'total': '5700',
                },
            ],
            columns: [
                {
                    field: 'date',
                    label: 'Date',
                },
                {
                    field: 'type',
                    label: 'Type',
                    centered: true
                },
                {
                    field: 'number',
                    label: 'Number',
                    centered: true
                },
                {
                    field: 'quantity',
                    label: 'Quantity',
                    centered: true
                },
                {
                    field: 'unit_price',
                    label: 'Unit Price',
                    centered: true
                },
                {
                    field: 'total',
                    label: 'Total',
                    centered: true
                },
            ]
        }
    },
    methods: {
        handleFilterHistories() {
            if (this.date) {
                const M = new Date(this.date).getMonth() + 1;
                const Y = new Date(this.date).getFullYear();
                console.log(M, Y)
            }
        }
    }
}
</script>

<style>
.trans_his .dropdown-item.active, .dropdown-item:active {
    background-color: transparent !important;
}
</style>
