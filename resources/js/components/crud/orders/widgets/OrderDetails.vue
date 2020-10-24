<template>
    <div class="mr-4">
        <div class="relative w-full c-name mb-2">
            <b-field
                label="Client's Name"
                custom-class="w-full text-sm"
                :type="has_contact_id ? 'is-danger' :null"
                :message="has_contact_id ? 'This field is required' : null"
            >
                <ClientLookupInput :selected="contact" :read_only="order.read_only" @on-select="handleClientSelect"/>
            </b-field>
        </div>
        <b-field
            label="Order Number" custom-class="text-sm"
            required
            :type="has_order_number ? 'is-danger' :null"
            :message="has_order_number ? 'This field is required' : null"
        >
            <b-input custom-class="text-sm" v-model="order.order_number"/>
        </b-field>
        <b-field label="Reference Number" custom-class="text-sm">
            <b-input v-model="order.reference_number"/>
        </b-field>
        <template >
            <b-field label="Contact Number" custom-class="text-sm" v-if="contact">
                <b-input custom-class="text-sm" v-model="order.delivery_contact_number" />
            </b-field>
            <div class="field" v-if="contact">
                <div class="flex flex-row justify-content-between align-items-center">
                    <label class="label text-sm">Delivery Address</label>
                    <b-button type="is-text" size="is-small" v-show="false">change</b-button>
                </div>
                <article class="message">
                    <section class="message-body p-3">
                        <div class="media">
                            <div class="media-content text-sm">
                                {{ contact.address ? contact.address : '---' }}
                            </div>
                        </div>
                    </section>
                </article>
            </div>
            <b-field label="Delivery Instructions"  custom-class="text-sm">
                <b-input custom-class="text-sm" type="textarea" v-model="order.delivery_instructions" rows="3"/>
            </b-field>
            <b-field label="Extra Note" custom-class="text-sm">
                <b-input custom-class="text-sm" type="textarea" v-model="order.note" rows="2"/>
            </b-field>
        </template>
    </div>
</template>

<script>
import ClientLookupInput from "@/components/global/lookup/clients/ClientLookupInput";

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
                delivery_address: null,
                delivery_contact_number: null,
                note: null
            },
            required_fields: {
                contact_id: true,
                order_number: true,
            },
            errors: {},
            contact: null,
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
            console.log(client)
            this.order = {
                ...this.order,
                contact_id: client ? client.id : null,
                delivery_address: client ? client.address : null,
                delivery_contact_number: client ? client.mobile : null
            }
            this.contact = client
        },
        resetErrors() {
            this.errors = {}
        },
    },
    computed: {
        has_contact_id() {
            return this.errors.contact_id !== undefined
        },
        has_order_number() {
            return this.errors.order_number !== undefined
        },
    },
    watch: {
        item(value) {
            this.order = {...value, ...value.delivery_details};
            this.contact = value.contact ? {...value.contact, ...value.delivery_details} : null
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
