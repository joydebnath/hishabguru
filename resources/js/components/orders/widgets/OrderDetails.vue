<template>
    <div class="mr-4">
        <div class="relative w-full c-name mb-2">
            <b-field
                label="Client Name"
                custom-class="w-full"
                :type="has_contact_id ? 'is-danger' :null"
                :message="has_contact_id ? 'This field is required' : null"
            >
                <ClientLookupInput :selected="contact" @on-select="handleClientSelect"/>
            </b-field>
        </div>
        <b-field
            label="Order Number"
            required
            :type="has_order_number ? 'is-danger' :null"
            :message="has_order_number ? 'This field is required' : null"
        >
            <b-input v-model="order.order_number"/>
        </b-field>
        <b-field label="Reference Number">
            <b-input v-model="order.reference_number"/>
        </b-field>
        <div class="field" v-show="client">
            <div class="flex flex-row justify-content-between align-items-center">
                <label class="label">Delivery Address</label>
                <b-button type="is-text" size="is-small" v-show="false">change</b-button>
            </div>
            <article class="message">
                <section class="message-body py-3">
                    <div class="media">
                        <div class="media-content" >
                            23 Main Street
                            Marineville
                            NSW
                            2000
                        </div>
                    </div>
                </section>
            </article>
        </div>
        <div class="field" v-show="client">
            <div class="flex flex-row justify-content-between align-items-center">
                <label class="label">Contact Number</label>
                <b-button type="is-text" size="is-small" v-show="false">change</b-button>
            </div>
            <article class="message">
                <section class="message-body py-2">
                    <div class="media">
                        <div class="media-content">
                            +61426000956
                        </div>
                    </div>
                </section>
            </article>
        </div>
        <b-field label="Delivery Instructions">
            <b-input type="textarea" v-model="order.delivery_instructions"/>
        </b-field>
    </div>
</template>

<script>
import ClientLookupInput from "./clients/ClientLookupInput";

export default {
    name: "OrderDetails",
    components: {ClientLookupInput},
    props: {
        item: Object | Array
    },
    data() {
        return {
            order: {
                contact_id: null,
                order_number: null,
                reference_number: null,
                delivery_instructions: null,
            },
            required_fields: {
                contact_id: true,
                order_number: true,
            },
            errors: {},
            contact: null
        }
    },
    methods: {
        validation() {
            let error_bag = {}
            for (let value in this.order) {
                if (this.required_fields[value] !== undefined && this.order[value] == null) {
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
                data: this.order,
                errors: this.errors
            }
        },
        handleClientSelect(client) {
            this.order = {...this.order, contact_id: client ? client.id : null}
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
        has_order_number() {
            return this.errors.order_number !== undefined
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
            this.order = value;
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
