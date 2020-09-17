<template>
    <div class="mr-4">
        <div class="relative w-full c-name mb-2">
            <b-field label="Client Name" custom-class="w-full">
                <b-input custom-class="w-full"></b-input>
<!--                <ClientDropdown/>-->
            </b-field>
        </div>
        <b-field label="Date">
            <b-datepicker
                v-model="date"
                :show-week-number="showWeekNumber"
                :locale="locale"
                placeholder="Click to select..."
                icon="calendar-today"
                trap-focus>
            </b-datepicker>
        </b-field>
        <b-field label="Order Number">
            <b-input></b-input>
        </b-field>
        <b-field label="Reference Number">
            <b-input></b-input>
        </b-field>
        <b-field label="Payment Condition">
            <b-select placeholder="Select one" class="w-full payment-condition">
                <option value="partial">Partial Payment</option>
                <option value="full">Full Payment</option>
                <option value="cash-on-delivery">Cash on Delivery</option>
                <option value="click-n-collect">Click and Collect</option>
            </b-select>
        </b-field>
        <b-field label="Extra Note">
            <b-input type="textarea"></b-input>
        </b-field>
    </div>
</template>

<script>
import ClientDropdown from "./clients/ClientDropdown";

export default {
    name: "QuotationDetails",
    components: {ClientDropdown},
    data() {
        return {
            date: new Date(),
            showWeekNumber: false,
            locale: undefined
        }
    }
}
</script>

<style>
.payment-condition .select,
.payment-condition select {
    width: 100% !important;
}
.c-name .control{
    width: 100%;
}
</style>
