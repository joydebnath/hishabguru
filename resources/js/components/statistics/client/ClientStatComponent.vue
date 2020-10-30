<template>
    <section class="max-w-6xl m-auto w-full mb-6 py-2">
        <Last12MonthsChart/>
        <PaymentDueTable/>
        <PurchaseHistories/>
    </section>
</template>

<script>
import Last12MonthsChart from "./widgets/Last12MonthsChart";
import PaymentDueTable from "./widgets/PaymentDueTable";
import PurchaseHistories from "./widgets/PurchaseHistoriesTable";

export default {
    name: "ClientStatComponent",
    components: {PurchaseHistories, PaymentDueTable, Last12MonthsChart}
}
</script>

<style scoped>

</style>
