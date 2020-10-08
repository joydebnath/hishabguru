<template>
    <div class="mr-4">
        <div class="relative w-full c-name mb-2">
            <b-field
                label="Client's Name"
                custom-class="w-full text-sm"
                :type="has_contact_id ? 'is-danger' :null"
                :message="has_contact_id ? 'This field is required' : null"
            >
                <ClientLookupInput
                    :selected="contact"
                    :read-only="quotation.read_only ? quotation.read_only : false"
                    @on-select="handleClientSelect"
                />
            </b-field>
        </div>
        <b-field
            label="Quotation Number"
            custom-class="text-sm"
            required
            :type="has_quotation_number ? 'is-danger' :null"
            :message="has_quotation_number ? 'This field is required' : null"
        >
            <b-input v-model="quotation.quotation_number"/>
        </b-field>
        <b-field label="Reference Number" custom-class="text-sm">
            <b-input v-model="quotation.reference_number"/>
        </b-field>
        <b-field
            label="Payment Condition"
            custom-class="text-sm"
            :type="has_payment_condition ? 'is-danger' :null"
            :message="has_payment_condition ? 'This field is required' : null"
        >
            <b-select
                @input="handlePaymentCondition"
                placeholder="Select one"
                v-model="quotation.payment_condition"
                class="w-full payment-condition"
            >
                <option value="partial">Partial Payment</option>
                <option value="full">Full Payment</option>
                <option value="cash-on-delivery">Cash on Delivery</option>
                <option value="click-n-collect">Click and Collect</option>
            </b-select>
        </b-field>
        <b-field
            v-if="(quotation.payment_condition === 'partial')"
            label="Minimum Payment Amount"
            custom-class="text-sm"
            :type="has_minimum_payment_amount ? 'is-danger' :null"
            :message="has_minimum_payment_amount ? 'This field is required' : null"
        >
            <b-input
                v-model="quotation.minimum_payment_amount"
                required
            />
        </b-field>
        <b-field label="Extra Note" custom-class="text-smce">
            <b-input type="textarea" v-model="quotation.note"/>
        </b-field>
    </div>
</template>

<script>
import ClientLookupInput from "@/components/global/lookup/clients/ClientLookupInput";

export default {
    name: "QuotationDetails",
    components: {ClientLookupInput},
    props: {
        item: Object | Array
    },
    data() {
        return {
            quotation: {
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
                payment_condition: true
            },
            errors: {},
            contact: null
        }
    },
    methods: {
        validation() {
            let error_bag = {}
            for (let value in this.quotation) {
                if (this.required_fields[value] !== undefined && this.quotation[value] == null) {
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
                data: this.quotation,
                errors: this.errors
            }
        },
        handleClientSelect(client) {
            this.quotation = {...this.quotation, contact_id: client ? client.id : null}
            this.contact = client
        },
        resetErrors() {
            this.errors = {}
        },
        handlePaymentCondition(value) {
            if (value === 'partial') {
                this.required_fields = {...this.required_fields, minimum_payment_amount: true};
                return
            }
            if (this.required_fields.minimum_payment_amount) {
                delete this.required_fields.minimum_payment_amount;
            }
            this.required_fields = {...this.required_fields};
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
    watch: {
        item(value) {
            this.quotation = value;
            this.contact = value.contact ? value.contact : null
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
