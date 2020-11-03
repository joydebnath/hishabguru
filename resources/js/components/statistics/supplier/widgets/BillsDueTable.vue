<template>
    <div class="box mt-6 p-4">
        <label class="heading text-lg">Awaiting bills</label>
        <div class="flex flex-row-reverse mb-2">
            <div class="flex flex-col text-right">
                <p class="subtitle is-6 mb-5">You Owe Them</p>
                <p class="title is-5 mb-0">1300 BDT</p>
            </div>
        </div>
        <b-table :data="histories" :columns="columns" class="text-sm"/>
    </div>
</template>

<script>
export default {
    name: "BillsDueTable",
    props: {
        supplier_id: String
    },
    mounted() {
        if (this.$props.supplier_id) {
            axios
                .get(`/supplier-statistics/${this.$props.supplier_id}/due-invoices`)
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
                    'type': 'Invoice',
                    'number': 'INV-001',
                    'due_date': '21/10/2016',
                    'due_amount': '1900',
                    'total': '5700',
                },
                {
                    'date': '2016-10-15 13:43:27',
                    'type': 'Invoice',
                    'number': 'INV-002',
                    'due_date': '21/10/2016',
                    'due_amount': '1900',
                    'total': '5700',
                },
                {
                    'date': '2016-10-15 13:43:27',
                    'type': 'Invoice',
                    'number': 'INV-003',
                    'due_date': '21/10/2016',
                    'due_amount': '1900',
                    'total': '5700',
                },
                {
                    'date': '2016-10-15 13:43:27',
                    'type': 'Invoice',
                    'number': 'INV-004',
                    'due_date': '21/10/2016',
                    'due_amount': '1900',
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
                    field: 'due_date',
                    label: 'Due Date',
                    centered: true
                },
                {
                    field: 'due_amount',
                    label: 'Due Amount',
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
