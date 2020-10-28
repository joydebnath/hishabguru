<template>
    <div class="max-w-6xl m-auto w-1/2 py-6">
        <MonthStatistics/>
        <div class="grid grid-cols-4 gap-4">
            <div class="col-span-2">
                <MonthCashFlow class="mb-4"/>
                <OrderDueToday class="mb-4"/>
                <CustomerDuePayments class="mb-4"/>
                <DueBills class="mb-4"/>
            </div>
            <div class="col-span-2">
                <Last30DaysSales class="mb-4"/>
                <Last30DaysExpenses class="mb-4"/>
                <Last30DaysProfits class="mb-4"/>
                <SalesByCategories/>
            </div>
        </div>
    </div>
</template>

<script>
import MonthStatistics from "./widgets/MonthStatistics";
import MonthCashFlow from "./widgets/MonthCashFlow";
import Last30DaysSales from "./widgets/Last30DaysSales";
import Last30DaysExpenses from "./widgets/Last30DaysExpenses";
import Last30DaysProfits from "./widgets/Last30DaysProfit";
import SalesByCategories from "./widgets/SalesByCategories";
import OrderDueToday from "./widgets/OrderDueToday";
import CustomerDuePayments from "./widgets/CustomerDuePayments";
import DueBills from "./widgets/DueBills";

export default {
    name: "DashboardComponent",
    components: {
        DueBills,
        CustomerDuePayments,
        OrderDueToday,
        SalesByCategories,
        Last30DaysProfits, Last30DaysExpenses, Last30DaysSales, MonthCashFlow, MonthStatistics,},
    data() {
        return {}
    }

}

</script>

