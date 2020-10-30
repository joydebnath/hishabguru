<template>
    <section class="max-w-6xl m-auto w-full mb-6 py-2">
        <ProductCurrentState/>
        <Last12MonthsChart/>
        <SellHistoriesTable/>
    </section>
</template>

<script>

import Last12MonthsChart from "./widgets/Last12MonthsChart";
import ProductCurrentState from "./widgets/ProductCurrentState";
import SellHistoriesTable from "./widgets/SellHistoriesTable";
export default {
    name: "ProductStatComponent",
    components: {
        SellHistoriesTable,
        ProductCurrentState,
        Last12MonthsChart
    },
    data() {
        return {

        }
    }
}
</script>

