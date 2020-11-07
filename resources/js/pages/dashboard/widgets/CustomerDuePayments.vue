<template>
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="text-base leading-6 font-medium text-gray-900">
                Customer Payment Due
            </h4>
        </div>
        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 overflow-auto" style="height: 300px;">

        </div>
    </div>

</template>

<script>
export default {
    name: "CustomerDuePayments",
    props:{
        tenant_id: String | Number
    },
    mounted() {
        if(this.$props.tenant_id){
            axios
                .get('/dashboard-statistics/top-due-invoices',{
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
}
</script>

<style scoped>

</style>
