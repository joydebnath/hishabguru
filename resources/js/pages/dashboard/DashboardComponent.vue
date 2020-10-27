<template>
    <div class="max-w-6xl m-auto w-1/2 py-6">
        <MonthStatistics/>
        <div class="grid grid-cols-4 gap-4">
            <div class="col-span-2">
                <MonthCashFlow/>
            </div>
            <div class="col-span-2">

            </div>
        </div>
    </div>
</template>

<script>

import MonthStatistics from "./widgets/MonthStatistics";
import MonthCashFlow from "./widgets/MonthCashFlow";

export default {
    name: "DashboardComponent",
    components: {MonthCashFlow,MonthStatistics},
    data() {
        return {

        }
    }

}

</script>

