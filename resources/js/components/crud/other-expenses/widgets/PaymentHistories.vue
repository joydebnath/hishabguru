<template>
    <section>
        <b-button size="is-small" class="font-medium tracking-wider mb-1" type="is-info is-light"
                  @click="show_table = !show_table">
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
        <DeleteBox
            :show="show_delete"
            :handler="onConfirmDelete"
            @on-close="handleDeleteClose"
        />
    </section>
</template>

<script>
import DeleteBox from "@/components/global/popups/DeleteBox";

export default {
    name: "PaymentHistories",
    components: {DeleteBox},
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
            show_table: false,
            selected: null,
            show_delete: false
        }
    },
    methods: {
        handleDelete(record) {
            this.selected = record
            this.show_delete = true
        },
        handleDeleteClose() {
            this.selected = null
            this.show_delete = false
        },
        onConfirmDelete() {
            this.loading = true;
            axios
                .delete('/payment-histories/' + this.selected.id)
                .then(({data}) => {
                    this.$emit('on-delete', this.selected);
                    this.loading = false;
                    this.handleDeleteClose()
                })
                .catch(err => {
                    this.loading = false;
                    console.log(err)
                })
        }
    }
}
</script>

<style scoped>

</style>
