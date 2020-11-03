<template>
    <section class="max-w-6xl m-auto w-full mb-6 py-2">
        <b-loading :is-full-page="true" v-model="loading" :can-cancel="false"/>
        <template v-if="!loading">
            <h2 class="heading text-right text-lg mb-2" v-if="supplier" v-text="supplier.name"></h2>
            <Last12MonthsChart :supplier_id="supplier_id"/>
            <BillsDueTable :supplier_id="supplier_id"/>
            <PurchaseHistoriesTable :supplier_id="supplier_id"/>
        </template>
    </section>
</template>

<script>
import Last12MonthsChart from "./widgets/Last12MonthsChart";
import BillsDueTable from "./widgets/BillsDueTable";
import PurchaseHistoriesTable from "./widgets/PurchaseHistoriesTable";

export default {
    name: "SupplierStatComponent",
    components: {PurchaseHistoriesTable, BillsDueTable, Last12MonthsChart},
    mounted() {
        this.supplier_id = this.$route.params.id;
        this.loading = true
        axios
            .get('/suppliers/' + this.$route.params.id)
            .then(({data}) => {
                this.supplier = data.data
                this.loading = false
            })
            .catch(err => {
                console.log(err)
                this.loading = false
                this.$router.push('/@/suppliers');
            })
    },
    data() {
        return {
            supplier: {},
            supplier_id: null,
            loading: false
        }
    }
}
</script>

<style scoped>

</style>
