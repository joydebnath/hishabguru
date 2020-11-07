<template>
    <VueApexCharts class="bg-white shadow pt-2 px-2 sm:rounded-lg" type="area" height="225" :options="chartOptions" :series="series"/>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'

export default {
    name: "Last30DaysExpenses",
    components: {VueApexCharts},
    data() {
        return {
            series: [{
                name: 'Number of expenses',
                data: [31, 40, 28, 51, 42, 109, 100]
            }],
            chartOptions: {
                title: {
                    text: "Last 30 Days - Total Expenses",
                    align: "left"
                },
                chart: {
                    height: 302,
                    type: 'area',
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#f6b02f'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'datetime',
                    categories: ["2018-09-19", "2018-09-20", "2018-09-21", "2018-09-22", "2018-09-23", "2018-09-24", "2018-09-25"],
                },
                yaxis: {
                    title: {
                        text: "Expense Amount"
                    },
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy'
                    },
                },
            }
        }
    }
}
</script>
