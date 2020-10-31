<template>
    <section class="max-w-6xl m-auto w-full mb-6 py-2">
        <h2 class="heading text-right text-lg mb-2">Client Name</h2>
        <Last12MonthsChart/>
        <PaymentsDueTable/>
        <PurchaseHistories/>
    </section>
</template>

<script>
import Last12MonthsChart from "./widgets/Last12MonthsChart";
import PaymentsDueTable from "./widgets/PaymentsDueTable";
import PurchaseHistories from "./widgets/PurchaseHistoriesTable";

export default {
    name: "ClientStatComponent",
    components: {PurchaseHistories, PaymentsDueTable, Last12MonthsChart}
}
</script>

<style scoped>

</style>
