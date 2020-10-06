<template>
    <section>
        <b-button size="is-small" class="mb-1" type="is-info is-light" @click="show_table = !show_table">
            <span v-if="show_table">Hide</span>
            <span v-else>Show</span>
            Payment Histories
        </b-button>
        <template v-if="show_table">
            <b-table :data="$props.payment_histories" :loading="loading" :narrowed="true">
                <b-table-column header-class="text-sm" field="payment_date" label="Payment Date" v-slot="props">
                    {{ props.row.payment_date }}
                </b-table-column>
                <b-table-column header-class="text-sm" field="amount" label="Paid" v-slot="props">
                    {{ props.row.amount }} {{ $props.currency }}
                </b-table-column>
                <b-table-column header-class="text-sm" field="payment_note" label="Payment Note" v-slot="props">
                    {{ props.row.payment_note }}
                </b-table-column>
                <b-table-column v-slot="props">
                    <b-button
                        type="is-danger is-light"
                        class="text-sm h-6 w-6 p-2"
                        icon-right="trash-can-outline"
                        @click="()=>handleDelete(props.row)"
                    />
                </b-table-column>
                <template slot="footer">
                    <th v-if="!$props.payment_histories.length" class="pt-0 text-center" colspan="4">
                        <div class="font-medium text-sm text-gray-700 tracking-wider">No Data</div>
                    </th>
                </template>
            </b-table>
        </template>
    </section>
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
    data() {
        return {
            loading: false,
            show_table: false
        }
    },
    methods: {
        handleDelete(record) {
            this.$buefy.dialog.confirm({
                message: '<h5 class="mb-2 font-medium text-xl">Deleting Payment Record</h5>Are you sure you want to delete?',
                confirmText: 'Delete',
                type: 'is-danger',
                onConfirm: () => {
                    this.loading = true;
                    axios
                        .delete('/payment-histories/' + record.id)
                        .then(({data}) => {
                            this.$emit('on-delete', record);
                            this.loading = false;
                        })
                        .catch(err => {
                            this.loading = false;
                            console.log(err)
                        })
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
