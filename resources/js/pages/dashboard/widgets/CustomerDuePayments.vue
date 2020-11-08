<template>
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="text-base leading-6 font-medium text-gray-900">
                Customer Payment Due
            </h4>
        </div>
        <div class="bg-white p-0 overflow-auto is-relative" style="height: 300px;max-height: 300px">
            <b-loading :is-full-page="false" v-model="loading" :can-cancel="false"/>
            <RecordRow
                v-for="record in records"
                :key="record.id"
                :top_left="record.contact_name"
                :bottom_left="record.number"
                :top_right="record.total_amount_formatted"
                :bottom_right="record.due_date"
                :url="`/@/invoices/${record.id}`"
                top_right_color="text-red-600 font-semibold"
                bottom_right_color="text-gray-700"
            />
            <div class="w-full h-full m-auto flex flex-row align-items-center justify-content-between"
                 v-if="records.length === 0">
                <div class="text-center d-inline-block w-full">
                    <svg class="w-5 h-5 d-inline-flex -mt-1" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M3 12L9 18L21 6"
                            stroke="#000"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                        </path>
                    </svg>
                    <span class="text-sm text-uppercase tracking-wider ml-1">No Due Payments</span>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import RecordRow from "./RecordRow";

export default {
    name: "CustomerDuePayments",
    components: {RecordRow},
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
                .get('/dashboard-statistics/top-due-invoices', {
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
