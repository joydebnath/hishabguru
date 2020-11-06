<template>
    <div class="box mt-6 p-4">
        <label class="heading text-lg">Purchase Histories - Paid</label>
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
        <b-table :data="computed_histories" :columns="columns" :loading="loading" class="text-sm mb-4">
            <template slot="footer">
                <EmptyTable v-if="!computed_histories.length" message="No Purchase Records"/>
            </template>
        </b-table>
    </div>
</template>

<script>
import EmptyTable from "@/components/global/table/EmptyTable";

export default {
    name: "PurchaseHistories",
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
            date: new Date(),
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
                    field: 'sub_total',
                    label: 'Sub Total',
                    centered: true
                },
                {
                    field: 'total_tax',
                    label: 'Total Tax',
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
        }
    },
    methods: {
        handleFilterHistories() {
            this.getRecords()
        },
        getDate() {
            return {
                month: new Date(this.date).getMonth() + 1,
                year: new Date(this.date).getFullYear()
            }
        },
        getRecords() {
            this.loading = true
            axios
                .get(`/client-statistics/${this.$props.client_id}/paid-invoices`, {
                    params: this.getDate()
                })
                .then(({data}) => {
                    this.histories = data.data
                    this.loading = false
                })
                .catch(err => {
                    console.log(err)
                    this.loading = false
                })
        }
    }
}
</script>

<style>
.trans_his .dropdown-item.active, .dropdown-item:active {
    background-color: transparent !important;
}
</style>
