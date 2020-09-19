<template>
    <div class="mr-4">
        <div class="relative w-full c-name mb-2">
            <b-field
                label="Client Name"
                custom-class="w-full"
                :type="has_contact_id ? 'is-danger' :null"
                :message="has_contact_id ? 'This field is required' : null"
            >
                <ClientLookupInput @on-select="handleClientSelect"/>
            </b-field>
        </div>
        <b-field
            label="Quotation Number"
            required
            :type="has_quotation_number ? 'is-danger' :null"
            :message="has_quotation_number ? 'This field is required' : null"
        >
            <b-input v-model="new_quotation.quotation_number"/>
        </b-field>
        <b-field label="Reference Number">
            <b-input v-model="new_quotation.reference_number"/>
        </b-field>
        <b-field
            label="Payment Condition"
            :type="has_payment_condition ? 'is-danger' :null"
            :message="has_payment_condition ? 'This field is required' : null"
        >
            <b-select
                @input="handlePaymentCondition"
                placeholder="Select one"
                v-model="new_quotation.payment_condition"
                class="w-full payment-condition"
            >
                <option value="partial">Partial Payment</option>
                <option value="full">Full Payment</option>
                <option value="cash-on-delivery">Cash on Delivery</option>
                <option value="click-n-collect">Click and Collect</option>
            </b-select>
        </b-field>
        <b-field
            v-if="(new_quotation.payment_condition === 'partial')"
            label="Minimum Payment Amount"
            :type="has_minimum_payment_amount ? 'is-danger' :null"
            :message="has_minimum_payment_amount ? 'This field is required' : null"
        >
            <b-input
                v-model="new_quotation.minimum_payment_amount"
                required
            />
        </b-field>
        <b-field label="Extra Note">
            <b-input type="textarea" v-model="new_quotation.note"/>
        </b-field>
    </div>
</template>

<script>
import ClientLookupInput from "./clients/ClientLookupInput";

export default {
    name: "QuotationDetails",
    components: {ClientLookupInput},
    data() {
        return {
            new_quotation: {
                contact_id: null,
                quotation_number: null,
                reference_number: null,
                payment_condition: null,
                note: null,
                minimum_payment_amount: null
            },
            required_fields: {
                contact_id: true,
                quotation_number: true,
                payment_condition: true,
                minimum_payment_amount: false
            },
            errors: {},
        }
    },
    methods: {
        validation() {
            let error_bag = {}
            for (let value in this.new_quotation) {
                if (this.required_fields[value] !== undefined && this.new_quotation[value] == null) {
                    error_bag[value] = true
                }
            }
            this.errors = error_bag
            console.log(error_bag)
        },
        collectData({validate}) {
            this.resetErrors()
            if (validate) {
                this.validation()
            }
            return {
                data: this.new_quotation,
                errors: this.errors
            }
        },
        handleClientSelect(client) {
            this.new_quotation = {...this.new_quotation, contact_id: client.id}
        },
        resetErrors() {
            this.errors = {}
        },
        handlePaymentCondition(value) {
            if (value === 'partial') {
                this.required_fields = {...this.required_fields, minimum_payment_amount: true};
                return
            }
            this.required_fields = {...this.required_fields, minimum_payment_amount: false};
        }
    },
    computed: {
        has_contact_id() {
            return this.errors.contact_id !== undefined
        },
        has_quotation_number() {
            return this.errors.quotation_number !== undefined
        },
        has_payment_condition() {
            return this.errors.payment_condition !== undefined
        },
        has_minimum_payment_amount() {
            return this.errors.minimum_payment_amount !== undefined
        },
    },
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
