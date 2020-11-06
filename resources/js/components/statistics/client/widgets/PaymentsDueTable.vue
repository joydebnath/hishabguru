<template>
    <div class="box mt-6 p-4">
        <label class="heading text-lg">Awaiting payments</label>
        <div class="flex flex-row-reverse mb-2">
            <div class="flex flex-col text-right">
                <p class="subtitle is-6 mb-5">They Owe You</p>
                <p class="title is-5 mb-0">{{ total_due }} BDT</p>
            </div>
        </div>
        <b-table :data="histories" :columns="columns" :loading="loading" class="text-sm mb-4">
            <template slot="footer">
                <EmptyTable v-if="!computed_histories.length" message="No Records"/>
            </template>
        </b-table>
    </div>
</template>

<script>
import EmptyTable from "@/components/global/table/EmptyTable";

export default {
    name: "PaymentsDueTable",
    components: {EmptyTable},
    props: {
        client_id: String
    },
    mounted() {
        if (this.$props.client_id) {
            this.getRecords()
        }
    },
    data() {
        return {
            histories: [],
            loading:false,
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
                    field: 'total_due',
                    label: 'Due Amount',
                    centered: true
                },
                {
                    field: 'total_tax',
                    label: 'Tax',
                    centered: true
                },
                {
                    field: 'total_amount',
                    label: 'Total',
                    centered: true
                },
            ]
        }
    },
    computed: {
        computed_histories() {
            return this.histories
        },
        total_due() {
            return _.sumBy(this.histories, 'total_due')
        }
    },
    methods: {
        getRecords() {
            this.loading = true;
            axios
                .get(`/client-statistics/${this.$props.client_id}/due-invoices`)
                .then(({data}) => {
                    this.histories = data.data
                    this.loading = false;
                })
                .catch(err => {
                    console.log(err)
                    this.loading = false;
                })
        }
    }
}
</script>
