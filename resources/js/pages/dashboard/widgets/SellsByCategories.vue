<template>
    <section class="bg-white shadow px-2 sm:rounded-lg">
        <b-loading :is-full-page="false" v-model="loading" :can-cancel="false"/>
        <div class="px-4 py-3 border-b border-gray-200">
            <div class="flex flex justify-content-between">
                <h4 class="text-sm leading-6 font-medium text-gray-900">
                    Last 30 Days - Most Sold Product Categories
                </h4>
                <span class="text-sm text-orange-500 leading-6" v-if="total">
                    {{ total }} {{ currency }}
                </span>
            </div>
        </div>
        <VueApexCharts class="pb-2" type="polarArea" height="280" :options="chartOptions" :series="series"/>
    </section>
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
            loading:false,
            series: [42, 47, 52, 58, 65],
            chartOptions: {
                chart: {
                    width: 280,
                    type: 'polarArea',
                    toolbar: {
                        show: false
                    }
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
