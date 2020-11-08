<template>
    <section>
        <b-table :data="$props.histories">
            <p v-if="$props.loading">
                <b-skeleton active/>
                <b-skeleton height="80px"/>
            </p>
            <b-table-column label="Payment Records" v-slot="props" v-if="!$props.loading">
                <p class="flex flex-row justify-content-between mb-1">
                    <span>{{ props.row.amount }} BDT</span>
                    <span class="tag is-light">{{ props.row.payment_date }}</span>
                </p>
                <p class="text-gray-700 text-sm">{{ props.row.note }}</p>
                <div class="flex flex-row-reverse mt-2">
                    <b-button
                        type="is-danger is-light"
                        class="text-base h-6 w-6 p-3"
                        icon-right="trash-can-outline"
                        @click="()=>handleDelete(props.row)"
                    />
                </div>
            </b-table-column>
            <template slot="footer" v-if="$props.histories.length === 0">
                <p class="text-gray-600 pb-10 pt-8 font-medium tracing-wider text-center">No record found</p>
            </template>
        </b-table>
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
        loading: Boolean,
        histories: Object | Array
    },
    data() {
        return {
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
            this.$emit('on-loading', true);
            axios
                .delete('/payment-histories/' + this.selected.id)
                .then(({data}) => {
                    this.$emit('on-delete', this.selected);
                    this.$emit('on-loading', false);
                    this.handleDeleteClose()
                })
                .catch(err => {
                    this.$emit('on-loading', false);
                    console.log(err)
                })
        }
    }
}
</script>
