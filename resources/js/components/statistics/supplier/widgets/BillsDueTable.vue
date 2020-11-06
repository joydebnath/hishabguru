<template>
    <div class="box mt-6 p-4">
        <label class="heading text-lg">Due Bills</label>
        <div class="flex flex-row-reverse mb-2">
            <div class="flex flex-col text-right">
                <p class="subtitle is-6 mb-5">You Owe Them</p>
                <p class="title is-5 mb-0">{{ total_due }} BDT</p>
            </div>
        </div>
        <b-table :data="histories" :loading="loading" class="text-sm mb-4">
            <b-table-column field="date" label="Date" v-slot="props">
                {{ props.row.date }}
            </b-table-column>
            <b-table-column field="type" label="Type" centered v-slot="props">
                {{ props.row.type }}
            </b-table-column>
            <b-table-column field="number" label="number" centered v-slot="props">
                {{ props.row.number }}
            </b-table-column>
            <b-table-column field="due_date" label="Due Date" centered v-slot="props">
                <span :class="[props.row.is_overdue ? 'text-red-600' : '']">{{ props.row.due_date }}</span>
            </b-table-column>
            <b-table-column field="total_due" label="Due Amount" centered v-slot="props">
                {{ props.row.total_due }}
            </b-table-column>
            <b-table-column field="total_tax" label="Tax" centered v-slot="props">
                {{ props.row.total_tax }}
            </b-table-column>
            <b-table-column field="total_amount" label="Total" centered v-slot="props">
                {{ props.row.total_amount }}
            </b-table-column>
            <template slot="footer">
                <EmptyTable v-if="!computed_histories.length" message="No Records"/>
            </template>
        </b-table>
    </div>
</template>

<script>
import EmptyTable from "@/components/global/table/EmptyTable";

export default {
    name: "BillsDueTable",
    components: {EmptyTable},
    props: {
        supplier_id: String
    },
    mounted() {
        if (this.$props.supplier_id) {
            this.getRecords()
        }
    },
    data() {
        return {
            date: null,
            histories: [],
            loading: false,
        }
    },
    computed: {
        computed_histories() {
            return this.histories
        },
        total_due() {
            return _.sumBy(this.histories, 'total_due')
        }
    },
    methods: {
        getRecords() {
            this.loading = true;
            axios
                .get(`/supplier-statistics/${this.$props.supplier_id}/due-bills`)
                .then(({data}) => {
                    this.histories = data.data
                    this.loading = false;
                })
                .catch(err => {
                    console.log(err)
                    this.loading = false;
                })
        }
    }
}
</script>
