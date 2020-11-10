<template>
    <section class="bg-white shadow px-2 sm:rounded-lg">
        <b-loading :is-full-page="false" v-model="loading" :can-cancel="false"/>
        <div class="px-4 py-3 border-b border-gray-200">
            <div class="flex flex justify-content-between">
                <h4 class="text-sm leading-6 font-medium text-gray-900">
                    Last 30 Days - Total Profits
                </h4>
                <span v-if="total" class="text-sm text-teal-600 leading-6">
                    {{ total }} {{ currency }}
                </span>
            </div>
        </div>
        <VueApexCharts
            :options="chartOptions" :series="series"
            height="200"
            type="area"
        />
    </section>

</template>

<script>
import VueApexCharts from 'vue-apexcharts'
import {mapGetters} from "vuex";

export default {
    name: "Last30DaysProfits",
    props: {
        tenant_id: String | Number
    },
    components: {VueApexCharts},
    mounted() {
        if (this.$props.tenant_id) {
            this.loading = true
            axios
                .get('/dashboard-statistics/last-30days-profits', {
                    params: {
                        tenant_id: this.$props.tenant_id
                    }
                })
                .then(({data: {timeline, data}}) => {
                    this.series = [{
                        name: 'Amount of profit from sales',
                        data: data
                    }];
                    this.chartOptions = {
                        ...this.chartOptions,
                        xaxis: {
                            type: 'datetime',
                            categories: timeline,
                        },
                    }
                    this.loading = false
                    this.total = _.reduce(data, (total, value) => parseFloat(total) + parseFloat(value))
                        .toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                })
                .catch(err => {
                    console.log(err)
                    this.loading = false
                })
        }
    },
    data() {
        return {
            total: 0,
            loading:false,
            series: [{
                name: 'Amount of profit from sales',
                data: []
            }],
            chartOptions: {
                chart: {
                    height: 200,
                    type: 'area',
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#67d9b7'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'datetime',
                    categories: [],
                },
                yaxis: {
                    title: {
                        text: "Profit Amount"
                    },
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy'
                    },
                },
            }
        }
    },
    computed: {
        ...mapGetters({
            'tenant_data': 'tenancy/getCurrentTenantData'
        }),
        currency() {
            return this.tenant_data.default_currency ?? ''
        }
    }
}
</script>
