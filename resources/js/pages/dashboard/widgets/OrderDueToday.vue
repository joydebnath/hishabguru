<template>
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-3 border-b border-gray-200">
            <div class="flex flex justify-content-between">
                <h4 class="text-base leading-6 font-medium text-gray-900">
                    Orders Due Today
                    <span class="text-teal-600 leading-6" v-if="records.length">
                        ({{ records.length }})
                    </span>
                </h4>
            </div>
        </div>
        <div class="bg-white p-0 overflow-auto is-relative" style="height: 300px;max-height: 300px">
            <b-loading :is-full-page="false" v-model="loading" :can-cancel="false"/>
            <RecordRow
                v-for="record in records"
                :key="record.id"
                :top_left="record.contact_name"
                :bottom_left="record.number"
                :top_right="record.total_amount_formatted"
                :bottom_right="record.status"
                :url="`/@/orders/${record.id}`"
            />
            <div class="w-full h-full m-auto flex flex-row align-items-center justify-content-between"
                 v-if="records.length === 0">
                <div class="text-center d-inline-block w-full">
                    <OrderIcon custom_class="w-5 h-5 d-inline-flex -mt-1"/>
                    <span class="text-sm text-uppercase tracking-wider ml-1">No Orders Due Today</span>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import RecordRow from "./RecordRow";
import OrderIcon from "@/components/icons/OrderIcon";

export default {
    name: "OrderDueToday",
    components: {OrderIcon, RecordRow},
    props: {
        tenant_id: String | Number
    },
    data() {
        return {
            records: [],
            loading: false
        }
    },
    mounted() {
        if (this.$props.tenant_id) {
            this.loading = true
            axios
                .get('/dashboard-statistics/order-due-today', {
                    params: {
                        tenant_id: this.$props.tenant_id
                    }
                })
                .then(({data}) => {
                    this.records = data.data
                    this.loading = false
                })
                .catch(err => {
                    console.log(err)
                    this.loading = false
                })
        }
    },
}
</script>

<style scoped>

</style>
