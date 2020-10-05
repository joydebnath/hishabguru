<template>
    <b-table :data="data">
        <b-table-column field="payment_date" label="Payment Date" v-slot="props">
            {{ props.row.payment_date }}
        </b-table-column>
        <b-table-column field="amount" label="Paid" v-slot="props">
            {{ props.row.amount }} {{$props.currency}}
        </b-table-column>
        <b-table-column field="payment_note" label="Payment Note" v-slot="props">
            {{ props.row.payment_note }}
        </b-table-column>
        <b-table-column v-slot="props">
            <b-button
                type="is-danger is-light"
                class="text-lg h-6 w-6 p-4"
                icon-right="trash-can-outline"
                @click="()=>delete(props.row)"
            />
        </b-table-column>
    </b-table>
</template>

<script>
export default {
    name: "PaymentHistories",
    props: {
        currency: {
            type: String,
            default: 'BDT'
        },
        payment_histories: Object | Array
    },
    methods: {
        delete(history) {

        }
    }
}
</script>

<style scoped>

</style>
