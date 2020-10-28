<template>
    <vue-frappe
        class="bg-white pt-4 shadow frappe sm:rounded-lg"
        type="axis-mixed"
        id="one"
        :labels="labels"
        :title="title"
        :height="300"
        :colors="colors"
        :dataSets="chartData"
        :tooltip-options="tooltipOptions"
        :axis-options="axisOptions"
        :bar-options="barOptions"
    >
    </vue-frappe>
</template>

<script>

import {VueFrappe} from 'vue2-frappe'

export default {
    name: "MonthCashFlow",
    components: {VueFrappe},
    data() {
        return {
            labels: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            colors: ['#41b7fc', '#e2e8f0'],
            chartData: [{
                name: "Cash In", chartType: 'bar',
                values: [2500, 4000, 3000, 3500, 800, 5200]
            },
                {
                    name: "Cash Out", chartType: 'bar',
                    values: [2500, 5000, 1000, 1500, 1800, 3200]
                },
            ],
            tooltipOptions: {
                formatTooltipX: d => (d + "Cash Flow"),
                formatTooltipY: d => thousands_separators(d) + " BDT"
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
    computed:{
        title(){
            return 'Monthly Cash Flow'
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
