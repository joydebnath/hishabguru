<template>
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-3 border-b border-gray-200">
            <div class="flex flex-row justify-content-between">
                <h4 class="text-base leading-6 font-medium text-gray-900">
                    Top Due Bills
                </h4>
                <div class="font-medium text-red-600" v-if="total !== '0.00'">{{total}} {{currency}}</div>
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
                :bottom_right="record.due_date"
                :url="`/@/bills/${record.id}`"
                top_right_color="text-orange-500 font-semibold"
                bottom_right_color="text-gray-700"
            />
            <div class="w-full h-full m-auto flex flex-row align-items-center justify-content-between"
                 v-if="records.length === 0">
                <div class="text-center d-inline-block w-full">
                    <CheckIcon custom_class="w-5 h-5 d-inline-flex -mt-1"/>
                    <span class="text-sm text-uppercase tracking-wider ml-1">No Due Bills</span>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import RecordRow from "./RecordRow";
import CheckIcon from "@/components/icons/CheckIcon";
import {mapGetters} from "vuex";
export default {
    name: "DueBills",
    components: {CheckIcon, RecordRow},
    props:{
        tenant_id: String | Number
    },
    data() {
        return {
            records: [],
            loading: false,
            total: '0.00'
        }
    },
    computed: {
        ...mapGetters({
            'tenant_data': 'tenancy/getCurrentTenantData'
        }),
        currency() {
            return this.tenant_data.default_currency ?? ''
        }
    },
    mounted() {
        if(this.$props.tenant_id && this.records.length === 0){
            this.loading = true
            axios
                .get('/dashboard-statistics/top-due-bills',{
                    params:{
                        tenant_id: this.$props.tenant_id
                    }
                })
                .then(({data})=>{
                    this.records = data.data
                    this.total = data.total_due
                    this.loading = false
                })
                .catch(err=>{
                    console.log(err)
                    this.loading = false
                })
        }
    },
}
</script>

<style scoped>

</style>
