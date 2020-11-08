<template>
    <div class="max-w-6xl m-auto w-1/2 py-6">
        <MonthStatistics :tenant_id="tenant_id"/>
        <div class="grid grid-cols-4 gap-4">
            <div class="col-span-2">
                <MonthCashFlow :tenant_id="tenant_id" class="mb-4"/>
                <OrderDueToday :tenant_id="tenant_id" class="mb-4"/>
                <CustomerDuePayments :tenant_id="tenant_id" class="mb-4"/>
                <DueBills :tenant_id="tenant_id" class="mb-4"/>
            </div>
            <div class="col-span-2">
                <Last30DaysSells :tenant_id="tenant_id" class="mb-4"/>
                <Last30DaysExpenses :tenant_id="tenant_id" class="mb-4"/>
                <Last30DaysProfits :tenant_id="tenant_id" class="mb-4"/>
                <SellsByCategories :tenant_id="tenant_id" class="mb-4"/>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import MonthStatistics from "./widgets/MonthStatistics";
import MonthCashFlow from "./widgets/MonthCashFlow";
import Last30DaysSells from "./widgets/Last30DaysSells";
import Last30DaysExpenses from "./widgets/Last30DaysExpenses";
import Last30DaysProfits from "./widgets/Last30DaysProfit";
import SellsByCategories from "./widgets/SellsByCategories";
import OrderDueToday from "./widgets/OrderDueToday";
import CustomerDuePayments from "./widgets/CustomerDuePayments";
import DueBills from "./widgets/DueBills";

export default {
    name: "DashboardComponent",
    components: {
        DueBills,
        CustomerDuePayments,
        OrderDueToday,
        SellsByCategories,
        Last30DaysProfits,
        Last30DaysExpenses,
        Last30DaysSells,
        MonthCashFlow,
        MonthStatistics,
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant'
        })
    }
}

</script>

