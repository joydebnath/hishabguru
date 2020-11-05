<template>
    <div class="box mt-6 p-4">
        <label class="heading text-lg">Transaction Histories - Sells</label>
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
        <b-table :data="computed_histories" :columns="columns" class="text-sm">
            <template slot="footer">
                <EmptyTable v-if="!computed_histories.length" message="No Sell Records"/>
            </template>
        </b-table>
    </div>
</template>

<script>
import EmptyTable from "@/components/global/table/EmptyTable";

export default {
    name: "SellHistoriesTable",
    components: {EmptyTable},

    props: {
        product_id: String
    },
    mounted() {
        if (this.$props.product_id) {
            this.getRecords();
        }
    },
    data() {
        return {
            date: new Date(),
            histories: [],
            columns: [
                {
                    field: 'issue_date',
                    label: 'Issued Date',
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
                    field: 'status',
                    label: 'Status',
                    centered: true
                },
                {
                    field: 'quantity',
                    label: 'Quantity',
                    centered: true
                },
                {
                    field: 'discount',
                    label: 'Discount %',
                    centered: true
                },
                {
                    field: 'tax_rate',
                    label: 'Tax %',
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
            axios
                .get(`/product-statistics/${this.$props.product_id}/sell-records`, {
                    params: this.getDate()
                })
                .then(({data}) => {
                    this.histories = data.data
                })
                .catch(err => {
                    console.log(err)
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
