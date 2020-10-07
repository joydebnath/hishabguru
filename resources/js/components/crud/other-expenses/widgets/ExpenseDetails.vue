<template>
    <div class="mr-4">
        <b-field
            label="Expense Number"
            custom-class="text-sm"
            required
            :type="has_expense_number ? 'is-danger' :null"
            :message="has_expense_number ? 'This field is required' : null"
        >
            <b-input custom-class="uppercase" v-model="expense.expense_number"/>
        </b-field>
        <b-field label="Reference Number" custom-class="text-sm">
            <b-input v-model="expense.reference_number"/>
        </b-field>
        <b-field label="Note" custom-class="text-sm">
            <b-input type="textarea" v-model="expense.note" rows="3"/>
        </b-field>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
    name: "BillDetails",
    props: {
        item: Object | Array
    },
    data() {
        return {
            expense: {
                expense_number: null,
                reference_number: null,
                note: null,
            },
            required_fields: {
                expense_number: true,
            },
            errors: {},
        }
    },
    methods: {
        validation() {
            let error_bag = {}
            for (let value in this.expense) {
                if (this.required_fields[value] !== undefined && this.expense[value] == null) {
                    error_bag[value] = true
                }
            }
            this.errors = error_bag
        },
        collectData({validate}) {
            this.resetErrors()
            if (validate) {
                this.validation()
            }
            return {
                data: {
                    ...this.expense,
                },
                errors: this.errors
            }
        },
        resetErrors() {
            this.errors = {}
        },
    },
    computed: {
        has_expense_number() {
            return this.errors.expense_number !== undefined
        },
    },
    watch: {
        item(value) {
            this.expense = value;
        }
    }
}
</script>

<style>
.payment-condition .select,
.payment-condition select {
    width: 100% !important;
}

.c-name .control {
    width: 100%;
}
</style>
