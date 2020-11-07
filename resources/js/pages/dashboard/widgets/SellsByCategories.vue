<template>
    <VueApexCharts class="bg-white shadow py-2 px-2 sm:rounded-lg" type="polarArea" height="325" :options="chartOptions" :series="series"/>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'

export default {
    name: "SellsByCategories",
    components: {VueApexCharts},
    props:{
        tenant_id: String | Number
    },
    mounted() {
        if(this.$props.tenant_id){
            axios
                .get('/dashboard-statistics/last-30days-categories',{
                    params:{
                        tenant_id: this.$props.tenant_id
                    }
                })
                .then(({data})=>{

                })
                .catch(err=>{
                    console.log(err)
                })
        }
    },
    data() {
        return {
            series: [42, 47, 52, 58, 65],
            chartOptions: {
                chart: {
                    width: 320,
                    type: 'polarArea',
                    toolbar: {
                        show: false
                    }
                },
                title: {
                    text: "Last 30 Days - Most Sold Product Categories",
                    align: "left"
                },
                labels: ['Rose A', 'Rose B', 'Rose C', 'Rose D', 'Rose E'],
                fill: {
                    opacity: 1
                },
                stroke: {
                    width: 1,
                    colors: undefined
                },
                yaxis: {
                    show: false
                },
                legend: {
                    position: 'bottom'
                },
                plotOptions: {
                    polarArea: {
                        rings: {
                            strokeWidth: 0
                        }
                    }
                },
                theme: {
                    monochrome: {
                        enabled: true,
                        shadeTo: 'light',
                        shadeIntensity: 0.6
                    }
                }
            }
        }
    }
}
</script>

<style scoped>

</style>
