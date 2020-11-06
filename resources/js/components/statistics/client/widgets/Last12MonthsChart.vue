<template>
    <VueApexCharts
        class="bg-white shadow pt-2 px-2 sm:rounded-lg"
        type="area"
        height="225"
        :options="computed_chart_options"
        :series="computed_series"
    />
</template>

<script>
import VueApexCharts from 'vue-apexcharts'

export default {
    name: "Last12MonthsChart",
    components: {
        VueApexCharts
    },
    props: {
        client_id: String
    },
    mounted() {
        if (this.$props.client_id) {
            axios
                .get(`/client-statistics/${this.$props.client_id}/last-twelvemonth`)
                .then(({data}) => {
                    const {months, invoice_amounts} = data;
                    this.series = [{
                        name: 'Total Spent',
                        type: 'column',
                        data: invoice_amounts.reverse()
                    }];
                    this.chartOptions = {...this.chartOptions, labels: months.reverse()}
                })
                .catch(err => {
                    console.log(err)
                })
        }
    },
    data() {
        return {
            series: [{
                name: 'Number of purchases made',
                type: 'column',
                data: []
            }],
            chartOptions: {
                chart: {
                    height: 225,
                    type: 'line',
                    toolbar: {
                        show: false
                    }
                },
                stroke: {
                    width: [0, 4]
                },
                title: {
                    text: 'Client\'s Purchase History - Last 12 Months'
                },
                dataLabels: {
                    enabled: true,
                    enabledOnSeries: [1]
                },
                labels: [],
                xaxis: {
                    type: 'year'
                },
                yaxis: [{
                    title: {
                        text: 'Money Spent',
                    },
                }]
            }
        }
    },
    computed: {
        computed_series() {
            return this.series
        },
        computed_chart_options() {
            return this.chartOptions
        },
    },
}
</script>

