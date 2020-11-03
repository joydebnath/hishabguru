<template>
    <VueApexCharts
        class="bg-white shadow pt-2 px-2 sm:rounded-lg"
        type="area"
        height="225"
        :options="chartOptions"
        :series="series"
    />
</template>

<script>
import VueApexCharts from 'vue-apexcharts'

export default {
    name: "Last12MonthsChart",
    components: {
        VueApexCharts
    },
    props:{
        client_id: String
    },
    mounted() {
        if (this.$props.client_id) {
            axios
                .get(`/client-statistics/${this.$props.client_id}/last-twelvemonth`)
                .then(({data}) => {

                })
                .catch(err => {

                })
        }
    },
    data() {
        return {
            series: [{
                name: 'Number of purchases made',
                type: 'column',
                data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160]
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
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
    }
}
</script>

