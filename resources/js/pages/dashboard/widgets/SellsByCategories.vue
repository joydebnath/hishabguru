<template>
    <section class="bg-white shadow px-2 sm:rounded-lg">
        <b-loading :is-full-page="false" v-model="loading" :can-cancel="false"/>
        <div class="px-4 py-3 border-b border-gray-200">
            <div class="flex flex justify-content-between">
                <h4 class="text-sm leading-6 font-medium text-gray-900">
                    Last 30 Days - Most Sold Product Categories
                </h4>
            </div>
        </div>
        <VueApexCharts
            class="pb-2 categories_polar_area"
            type="polarArea"
            height="280"
            :options="computed_chart_options"
            :series="computed_series"
        />
    </section>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'

export default {
    name: "SellsByCategories",
    components: {VueApexCharts},
    props: {
        tenant_id: String | Number
    },
    mounted() {
        if (this.$props.tenant_id) {
            this.loading = true
            axios
                .get('/dashboard-statistics/last-30days-categories', {
                    params: {
                        tenant_id: this.$props.tenant_id
                    }
                })
                .then(({data}) => {
                    this.loading = false
                    this.series = _.map(data, 'count');
                    this.chartOptions = {
                        ...this.chartOptions,
                        labels: _.map(data, 'name')
                    };
                })
                .catch(err => {
                    this.loading = false
                    console.log(err)
                })
        }
    },
    data() {
        return {
            loading: false,
            series: [],
            chartOptions: {
                chart: {
                    width: 280,
                    type: 'polarArea',
                    toolbar: {
                        show: false
                    }
                },
                labels: [],
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
    },
    computed: {
        computed_series() {
            return this.series
        },
        computed_chart_options() {
            return this.chartOptions
        }
    }
}
</script>

<style>
.categories_polar_area .apexcharts-canvas {
    margin: auto;
}
</style>
