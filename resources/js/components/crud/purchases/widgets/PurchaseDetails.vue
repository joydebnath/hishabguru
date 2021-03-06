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
                    :read_only="purchase_order.read_only"
                    @on-select="handleSupplierSelect"
                />
            </b-field>
        </div>
        <b-field
            label="Purchase Order Number"
            custom-class="text-sm"
            required
            :type="has_purchase_order_number ? 'is-danger' :null"
            :message="has_purchase_order_number ? 'This field is required' : null"
        >
            <b-input custom-class="uppercase text-sm" v-model="purchase_order.purchase_order_number" readonly/>
        </b-field>
        <b-field label="Reference Number" custom-class="text-sm">
            <b-input custom-class="text-sm" v-model="purchase_order.reference_number"/>
        </b-field>
        <div class="field">
            <div class="flex flex-row justify-content-between align-items-center">
                <label class="label text-sm">Delivery Address</label>
                <b-button v-if="is_changeable_inventory" type="is-text" size="is-small" @click="handleChangeAddress">
                    change
                </b-button>
            </div>
            <article class="message">
                <section class="message-body py-3">
                    <div class="media">
                        <div class="media-content">
                            <template v-if="selected_inventory">
                                <p class="font-medium">{{ selected_inventory.name }}</p>
                                <p class="text-sm">{{ selected_inventory.formatted_address }}</p>
                            </template>
                            <template v-else>
                                <p class="text-center">
                                    Select Inventory Site
                                </p>
                            </template>
                        </div>
                    </div>
                </section>
            </article>
        </div>
        <b-field label="Note" custom-class="text-sm">
            <b-input type="textarea" custom-class="text-sm" v-model="purchase_order.note" rows="3"/>
        </b-field>
        <UploadedFiles v-if="false"/>
        <SelectDeliverySite
            :show="changeable_address"
            @on-select="handleDeliverySiteSelected"
            @on-close="handleCloseSelectAddress"
        />
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import SupplierLookupInput from "@/components/global/lookup/suppliers/SupplierLookupInput";
import SelectDeliverySite from "./SelectDeliverySite";
import UploadedFiles from "./UploadedFiles";

export default {
    name: "PurchaseDetails",
    components: {UploadedFiles, SelectDeliverySite, SupplierLookupInput},
    props: {
        item: Object | Array
    },
    data() {
        return {
            purchase_order: {
                contact_id: null,
                purchase_order_number: null,
                reference_number: null,
                note: null,
                delivery_site: null
            },
            required_fields: {
                contact_id: true,
                purchase_order_number: true,
                delivery_site: true
            },
            errors: {},
            contact: null,
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
                data: {
                    ...this.purchase_order,
                    delivery_site: this.selected_inventory
                },
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
        },
        handleDeliverySiteSelected(site) {
            this.purchase_order = {...this.purchase_order, delivery_site: site}
        }
    },
    computed: {
        ...mapGetters({
            inventories: 'tenancy/getCurrentInventories'
        }),
        selected_inventory() {
            if (this.purchase_order.delivery_site) {
                return this.purchase_order.delivery_site;
            }
            this.purchase_order.delivery_site = _.first(this.inventories)
            return this.purchase_order.delivery_site;
        },
        is_changeable_inventory() {
            return this.inventories && this.inventories.length > 1
        },
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
