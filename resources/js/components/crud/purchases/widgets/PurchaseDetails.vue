<template>
    <div class="mr-4">
        <div class="relative w-full c-name mb-2">
            <b-field
                label="Supplier Name"
                custom-class="w-full"
                :type="has_contact_id ? 'is-danger' :null"
                :message="has_contact_id ? 'This field is required' : null"
            >
                <SupplierLookupInput :selected="contact" @on-select="handleSupplierSelect"/>
            </b-field>
        </div>
        <b-field
            label="Purchase Order Number"
            required
            :type="has_purchase_order_number ? 'is-danger' :null"
            :message="has_purchase_order_number ? 'This field is required' : null"
        >
            <b-input v-model="purchase_order.purchase_order_number"/>
        </b-field>
        <b-field label="Reference Number">
            <b-input v-model="purchase_order.reference_number"/>
        </b-field>
        <div class="field">
            <div class="flex flex-row justify-content-between align-items-center">
                <label class="label">Delivery Address</label>
                <b-button type="is-text" size="is-small" @click="handleChangeAddress">change</b-button>
            </div>
            <article class="message">
                <section class="message-body py-3">
                    <div class="media">
                        <div class="media-content">
                            <template v-if="false">
                                <p class="text-center">
                                    Select Inventory Site
                                </p>
                            </template>
                            <template v-else>
                                <p class="font-medium">Online store</p>
                                <p class="text-sm">295/ka, Tali Office Road, Rayer Bazar, Dhaka 1209</p>
                            </template>
                        </div>
                    </div>
                </section>
            </article>
        </div>
        <b-field label="Note">
            <b-input type="textarea" v-model="purchase_order.note" rows="3"/>
        </b-field>
        <SelectDeliverySite :show="changeable_address" @on-close="handleCloseSelectAddress"/>
    </div>
</template>

<script>
import SupplierLookupInput from "./suppliers/SupplierLookupInput";
import SelectDeliverySite from "./SelectDeliverySite";

export default {
    name: "PurchaseDetails",
    components: {SelectDeliverySite, SupplierLookupInput},
    props: {
        item: Object | Array
    },
    data() {
        return {
            purchase_order: {
                contact_id: null,
                purchase_order_number: null,
                reference_number: null,
                note: null
            },
            required_fields: {
                contact_id: true,
                purchase_order_number: true,
            },
            errors: {},
            contact: null,
            site_address: null,
            changeable_address: false,
        }
    },
    methods: {
        validation() {
            let error_bag = {}
            for (let value in this.purchase_order) {
                if (this.required_fields[value] !== undefined && this.purchase_order[value] == null) {
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
                data: this.purchase_order,
                errors: this.errors
            }
        },
        handleSupplierSelect(supplier) {
            this.purchase_order = {
                ...this.purchase_order,
                contact_id: supplier ? supplier.id : null,
            }
            this.contact = supplier
        },
        resetErrors() {
            this.errors = {}
        },
        handleChangeAddress() {
            this.changeable_address = true;
        },
        handleCloseSelectAddress() {
            this.changeable_address = false;
        }
    },
    computed: {
        has_contact_id() {
            return this.errors.contact_id !== undefined
        },
        has_purchase_order_number() {
            return this.errors.purchase_order_number !== undefined
        },
    },
    watch: {
        item(value) {
            this.purchase_order = value;
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