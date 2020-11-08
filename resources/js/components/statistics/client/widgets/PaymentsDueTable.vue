<template>
    <div class="box mt-6 p-4">
        <label class="heading text-lg">Awaiting payments</label>
        <div class="flex flex-row-reverse mb-2">
            <div class="flex flex-col text-right">
                <p class="subtitle is-6 mb-5">They Owe You</p>
                <p class="title is-5 mb-0">{{ total_due }} {{ currency }}</p>
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
import {mapGetters} from "vuex";

export default {
    name: "PaymentsDueTable",
    components: {EmptyTable},
    props: {
        client_id: String
    },
    mounted() {
        if (this.$props.client_id) {
            this.getRecords()
        }
    },
    data() {
        return {
            histories: [],
            loading: false,
        }
    },
    computed: {
        ...mapGetters({
            tenant_data: 'tenancy/getCurrentTenantData'
        }),
        computed_histories() {
            return this.histories
        },
        total_due() {
            return _.sumBy(this.histories, 'total_due')
        },
        currency() {
            return this.tenant_data.default_currency ?? ''
        }
    },
    methods: {
        getRecords() {
            this.loading = true;
            axios
                .get(`/client-statistics/${this.$props.client_id}/due-invoices`)
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
