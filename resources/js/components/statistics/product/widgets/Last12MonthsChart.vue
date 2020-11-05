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
        product_id: String
    },
    mounted() {
        if (this.$props.product_id) {
            axios
                .get(`/product-statistics/${this.$props.product_id}/last-twelvemonth`)
                .then(({data}) => {
                    const {months, sell_counts} = data;
                    this.series = [{
                        name: 'Total Sold',
                        type: 'column',
                        data: sell_counts.reverse()
                    }];
                    this.chartOptions = {...this.chartOptions, labels: months.reverse()}
                })
                .catch(err => {
                    console.log(err)
                })
        }
    },
    computed:{
        computed_series(){
            return this.series
        },
        computed_chart_options(){
            return this.chartOptions
        },
    },
    data() {
        return {
            series: [{
                name: 'Total Sold',
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
                    text: 'Product Sale History - Last 12 Months'
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
                        text: 'Sales numbers',
                    },
                }]
            }
        }
    },
}
</script>

