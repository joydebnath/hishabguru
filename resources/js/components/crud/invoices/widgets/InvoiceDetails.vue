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
                    :read_only="invoice.read_only"
                    @on-select="handleSupplierSelect"
                />
            </b-field>
        </div>
        <b-field
            label="Invoice Number"
            custom-class="text-sm"
            required
            :type="has_invoice_number ? 'is-danger' :null"
            :message="has_invoice_number ? 'This field is required' : null"
        >
            <b-input custom-class="uppercase text-sm" v-model="invoice.invoice_number"/>
        </b-field>
        <b-field label="Reference Number" custom-class="text-sm">
            <b-input custom-class="text-sm" v-model="invoice.reference_number"/>
        </b-field>
        <b-field label="Message" custom-class="text-sm">
            <b-input custom-class="text-sm" type="textarea" v-model="invoice.note" rows="3"/>
        </b-field>
        <UploadedFiles v-if="false"/>
    </div>
</template>

<script>

import ClientLookupInput from "@/components/global/lookup/clients/ClientLookupInput";
import UploadedFiles from "./UploadedFiles";

export default {
    name: "InvoiceDetails",
    components: {UploadedFiles, ClientLookupInput},
    props: {
        item: Object | Array
    },
    data() {
        return {
            invoice: {
                contact_id: null,
                invoice_number: null,
                reference_number: null,
                note: null,
            },
            required_fields: {
                contact_id: true,
                invoice_number: true,
            },
            errors: {},
            contact: null,
            changeable_address: false,
        }
    },
    methods: {
        validation() {
            let error_bag = {}
            for (let value in this.invoice) {
                if (this.required_fields[value] !== undefined && this.invoice[value] == null) {
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
                    ...this.invoice,
                },
                errors: this.errors
            }
        },
        handleSupplierSelect(supplier) {
            this.invoice = {
                ...this.invoice,
                contact_id: supplier ? supplier.id : null,
            }
            this.contact = supplier
        },
        resetErrors() {
            this.errors = {}
        },
    },
    computed: {
        has_contact_id() {
            return this.errors.contact_id !== undefined
        },
        has_invoice_number() {
            return this.errors.invoice_number !== undefined
        },
    },
    watch: {
        item(value) {
            this.invoice = value;
            this.contact = value.contact ? {...value.contact} : null
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
