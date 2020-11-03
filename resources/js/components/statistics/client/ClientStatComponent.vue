<template>
    <section class="max-w-6xl m-auto w-full mb-6 py-2">
        <b-loading :is-full-page="true" v-model="loading" :can-cancel="false"/>
        <template v-if="!loading">
            <h2 class="heading text-right text-lg mb-2" v-if="client" v-text="client.name"></h2>
            <Last12MonthsChart :client_id="client_id"/>
            <PaymentsDueTable :client_id="client_id"/>
            <PurchaseHistories :client_id="client_id"/>
        </template>
    </section>
</template>

<script>
import Last12MonthsChart from "./widgets/Last12MonthsChart";
import PaymentsDueTable from "./widgets/PaymentsDueTable";
import PurchaseHistories from "./widgets/PurchaseHistoriesTable";

export default {
    name: "ClientStatComponent",
    components: {PurchaseHistories, PaymentsDueTable, Last12MonthsChart},
    mounted() {
        this.client_id = this.$route.params.id;
        this.loading = true
        axios
            .get('/clients/' + this.$route.params.id)
            .then(({data}) => {
                this.client = data.data
                this.loading = false
            })
            .catch(err => {
                console.log(err)
                this.loading = false
                this.$router.push('/@/clients');
            })
    },
    data() {
        return {
            client: {},
            client_id: null,
            loading: false
        }
    }
}
</script>

<style scoped>

</style>
