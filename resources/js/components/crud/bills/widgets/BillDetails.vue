<template>
    <div class="mr-4">
        <div class="relative w-full c-name mb-2">
            <b-field
                label="Supplier's Name"
                custom-class="w-full text-sm"
                :type="has_contact_id ? 'is-danger' :null"
                :message="has_contact_id ? 'This field is required' : null"
            >
                <SupplierLookupInput
                    :selected="contact"
                    :read_only="bill.read_only ? bill.read_only: false"
                    @on-select="handleSupplierSelect"
                />
            </b-field>
        </div>
        <b-field
            label="Bill Number"
            custom-class="text-sm"
            required
            :type="has_bill_number ? 'is-danger' :null"
            :message="has_bill_number ? 'This field is required' : null"
        >
            <b-input custom-class="uppercase text-sm" v-model="bill.bill_number"/>
        </b-field>
        <b-field label="Reference Number" custom-class="text-sm">
            <b-input custom-class="text-sm" v-model="bill.reference_number"/>
        </b-field>
        <b-field label="Note" custom-class="text-sm">
            <b-input custom-class="text-sm" type="textarea" v-model="bill.note" rows="3"/>
        </b-field>
        <UploadedFiles v-if="false"/>
    </div>
</template>

<script>
import SupplierLookupInput from "@/components/global/lookup/suppliers/SupplierLookupInput";
import UploadedFiles from "./UploadedFiles";

export default {
    name: "BillDetails",
    components: {UploadedFiles, SupplierLookupInput},
    props: {
        item: Object | Array
    },
    data() {
        return {
            bill: {
                contact_id: null,
                bill_number: null,
                reference_number: null,
                note: null,
            },
            required_fields: {
                contact_id: true,
                bill_number: true,
            },
            errors: {},
            contact: null,
            changeable_address: false,
        }
    },
    methods: {
        validation() {
            let error_bag = {}
            for (let value in this.bill) {
                if (this.required_fields[value] !== undefined && this.bill[value] == null) {
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
                    ...this.bill,
                },
                errors: this.errors
            }
        },
        handleSupplierSelect(supplier) {
            this.bill = {
                ...this.bill,
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
        has_bill_number() {
            return this.errors.bill_number !== undefined
        },
    },
    watch: {
        item(value) {
            this.bill = value;
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
