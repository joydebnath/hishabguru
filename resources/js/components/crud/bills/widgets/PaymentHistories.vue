<template>
    <b-table :data="$props.histories">
        <b-loading :is-full-page="false" v-model="$props.loading" :can-cancel="false"/>
        <b-table-column label="Payment Records" v-slot="props" v-if="!$props.loading">
            <p class="flex flex-row justify-content-between mb-1">
                <span>{{ props.row.amount }} BDT</span>
                <span class="tag is-light">{{ new Date(props.row.payment_date).toLocaleDateString() }}</span>
            </p>
            <p class="text-gray-700 text-sm">{{ props.row.note }}</p>
            <div class="flex flex-row-reverse mt-2">
                <b-button
                    type="is-danger is-light"
                    class="text-base h-6 w-6 p-3"
                    icon-right="trash-can-outline"
                    @click="handleDelete"
                />
            </div>
        </b-table-column>
        <template slot="footer" v-if="$props.histories.length === 0">
            <p class="text-gray-600 pb-10 pt-8 font-medium tracing-wider text-center">No record found</p>
        </template>
    </b-table>
</template>

<script>
export default {
    name: "PaymentHistories",
    props:{
        loading: Boolean,
        histories: Object | Array
    },
    methods:{
        handleDelete(){

        }
    }
}
</script>
