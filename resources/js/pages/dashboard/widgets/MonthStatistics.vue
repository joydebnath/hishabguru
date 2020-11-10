<template>
    <nav class="level box shadow">
            <span class="text-gray-700 flex flex-col align-items-center">
                <small class="mb-0">Statistics</small>
                <span class="text-uppercase tracking-wider">{{ current_month_name }}</span>
            </span>
        <div class="level-item has-text-centered">
            <div>
                <p class="heading text-green-700">Incomes</p>
                <p class="title flex flex-row justify-content-center">
                    <template>{{ current_month_stats.incomes }}</template>
                    <b-skeleton v-if="loading" width="60px" height="10" :animated="true"/>
                </p>
            </div>
        </div>
        <div class="level-item has-text-centered">
            <div>
                <p class="heading text-orange-600">Expenses</p>
                <p class="title flex flex-row justify-content-center">
                    <template>{{ current_month_stats.expenses }}</template>
                    <b-skeleton v-if="loading" width="60px" height="10" :animated="true"/>
                </p>
            </div>
        </div>
        <div class="level-item has-text-centered">
            <div>
                <p class="heading text-red-700">Bills to pay</p>
                <p class="title flex flex-row justify-content-center">
                    <template>{{ current_month_stats.due_bills }}</template>
                    <b-skeleton v-if="loading" width="60px" height="10" :animated="true"/>
                </p>
            </div>
        </div>
        <div class="level-item has-text-centered">
            <div>
                <p class="heading text-gray-800">Customer Due</p>
                <p class="title flex flex-row justify-content-center"
                   :class="customer_text_due_color">
                    <template>{{ current_month_stats.due_invoices }}</template>
                    <b-skeleton v-if="loading" width="60px" height="10" :animated="true"/>
                </p>
            </div>
        </div>
    </nav>
</template>

<script>
import VueApexCharts from "vue-apexcharts";

export default {
    name: "MonthStatistics",
    props: {
        tenant_id: String | Number
    },
    components: {VueApexCharts},
    mounted() {
        if (this.$props.tenant_id && _.isEmpty(this.records)) {
            this.loading = true
            axios
                .get('/dashboard-statistics/current-month-statistics', {
                    params: {
                        tenant_id: this.$props.tenant_id
                    }
                })
                .then(({data}) => {
                    this.records = data;
                    this.loading = false;
                })
                .catch(err => {
                    console.log(err)
                    this.loading = false
                })
        }
    },
    computed: {
        current_month_name() {
            return new Date().toLocaleString('default', {month: 'long'});
        },
        current_month_stats() {
            return this.records
        },
        customer_text_due_color() {
            return this.current_month_stats.due_invoices && this.current_month_stats.due_invoices > 0 ?
                'text-red-600' : ''
        }
    },
    data() {
        return {
            loading: false,
            records: {}
        }
    },
}
</script>

