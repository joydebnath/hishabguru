<template>
    <vue-frappe
        class="bg-white pt-4 shadow frappe sm:rounded-lg"
        type="axis-mixed"
        id="one"
        :labels="computed_labels"
        :title="title"
        :height="300"
        :colors="colors"
        :dataSets="computed_chart_data"
        :tooltip-options="tooltipOptions"
        :axis-options="axisOptions"
        :bar-options="barOptions"
    >
    </vue-frappe>
</template>

<script>
import {mapGetters} from 'vuex'
import {VueFrappe} from 'vue2-frappe'

export default {
    name: "MonthCashFlow",
    components: {VueFrappe},
    props: {
        tenant_id: String | Number
    },
    mounted() {
        if (this.$props.tenant_id) {
            axios
                .get('/dashboard-statistics/monthly-cash-flow', {
                    params: {
                        tenant_id: this.$props.tenant_id
                    }
                })
                .then(({data}) => {
                    const {cash_in_amount, cash_out_amount, months} = data
                    this.labels = months.reverse()
                    this.chartData = [{
                        name: "Cash In", chartType: 'bar',
                        values: cash_in_amount.reverse()
                    },
                        {
                            name: "Cash Out", chartType: 'bar',
                            values: cash_out_amount.reverse()
                        },
                    ];
                    console.log(this.tenant_data)
                })
                .catch(err => {
                    console.log(err)
                })
        }
    },
    data() {
        return {
            labels: [],
            colors: ['#41b7fc', '#e2e8f0'],
            chartData: [{
                name: "Cash In", chartType: 'bar',
                values: [0, 0, 0, 0, 0, 0]
            },
                {
                    name: "Cash Out", chartType: 'bar',
                    values: [0, 0, 0, 0, 0, 0]
                },
            ],
            tooltipOptions: {
                formatTooltipX: d => (d + "Cash Flow"),
                formatTooltipY: d => thousands_separators(d) + ' ' + this.currency
            },
            axisOptions: {
                xAxisMode: "tick",
                xIsSeries: true
            },
            barOptions: {
                stacked: false,
                spaceRatio: 0.5
            },
        }
    },
    computed: {
        ...mapGetters({
            'tenant_data': 'tenancy/getCurrentTenantData'
        }),
        title() {
            return 'Monthly Cash Flow'
        },
        computed_labels() {
            return this.labels
        },
        computed_chart_data() {
            return this.chartData
        },
        currency() {
            return this.tenant_data.default_currency ?? 'N/A'
        }
    }
}


function thousands_separators(num) {
    let num_parts = num.toString().split(".");
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return num_parts.join(".");
}
</script>

<style>
.frappe .title {
    font-size: 14px;
    font-family: BlinkMacSystemFont, -apple-system, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", "Helvetica", "Arial", sans-serif !important;
}
</style>
