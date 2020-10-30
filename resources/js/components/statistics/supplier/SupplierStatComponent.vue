<template>
    <section class="max-w-6xl m-auto w-full mb-6 py-2">
        <Last12MonthsChart/>
        <BillsDueTable/>
        <PurchaseHistoriesTable/>
    </section>
</template>

<script>
import Last12MonthsChart from "./widgets/Last12MonthsChart";
import BillsDueTable from "./widgets/BillsDueTable";
import PurchaseHistoriesTable from "./widgets/PurchaseHistoriesTable";

export default {
    name: "SupplierStatComponent",
    components: {PurchaseHistoriesTable, BillsDueTable, Last12MonthsChart}
}
</script>

<style scoped>

</style>
