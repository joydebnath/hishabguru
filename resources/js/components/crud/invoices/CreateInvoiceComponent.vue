<template>
    <div class="max-w-6xl m-auto w-full mb-6 py-2">
        <Breadcrumb active_link_name="New Invoice"/>
        <div class="box pt-6 pb-0">
            <b-loading :is-full-page="false" v-model="loading" :can-cancel="false"/>
            <HeaderActions v-if="false" :show_option="false" :show_print="false"/>
            <div class="grid grid-cols-7 gap-2">
                <div class="col-span-2">
                    <InvoiceDetails ref="part1" :item="computed_item"/>
                </div>
                <div class="col-span-5 ml-4">
                    <ProductsTable ref="part2" :item="computed_item"/>
                    <div class="mx-12 mt-4">
                        <b-message
                            type="is-danger"
                            size="is-small"
                            :auto-close="true"
                            :duration="4000"
                            v-model="error_container"
                        >
                            <span class="tracking-wider" v-text="error_message"></span>
                        </b-message>
                    </div>
                </div>
            </div>
            <FooterActions
                cancel_route="/@/invoices"
                @on-save-as-draft="handleDraft"
                @on-save="handleSave"
                @on-save-for-approval="handleSaveForApproval"
            />
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import InvoiceDetails from "./widgets/InvoiceDetails";
import ProductsTable from "./widgets/ProductsTable";
import Breadcrumb from "./widgets/Breadcrumb";
import FooterActions from "@/components/global/crud/FooterActions";
import {store} from "@/repos/invoices";
import HeaderActions from "./widgets/HeaderActions";

export default {
    name: "CreateInvoiceComponent",
    components: {HeaderActions, Breadcrumb, FooterActions, ProductsTable, InvoiceDetails},
    data() {
        return {
            error_container: false,
            error_message: '',
            invoice: {},
            loading: false
        }
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant',
            total: 'invoices/getTotal',
            per_page: 'getPerPage'
        }),
        computed_item() {
            return this.invoice
        }
    },
    methods: {
        handleDraft() {
            let invoice = {};
            _.forEach(this.$refs, value => {
                let {data} = value.collectData({validate: false});
                invoice = {...invoice, ...data}
            });

            if (invoice.invoice_number == null) {
                this.error_container = true;
                this.error_message = 'Invoice number can not be empty!';
                return;
            }

            invoice['status'] = 'draft';
            this.createInvoice(invoice, 'Invoice Draft is created')
        },
        handleSave() {
            let invoice = {}, error_bag = {};
            _.forEach(this.$refs, value => {
                let {data, errors} = value.collectData({validate: true});
                invoice = {...invoice, ...data}
                error_bag = {...error_bag, ...errors}
            });

            if (error_bag['products']) {
                this.error_container = true
                this.error_message = 'Products list can not be empty!'
            }

            if (_.isEmpty(error_bag)) {
                invoice['status'] = 'due';
                this.createInvoice(invoice, 'Invoice is created')
            }
        },
        handleSaveForApproval() {
            console.log('awaiting-for-approve')
        },
        createInvoice(invoice, message) {
            this.loading = true;
            store({...invoice, tenant_id: this.tenant_id})
                .then(({data}) => {
                    this.onSuccess(message)
                })
                .catch(err => {
                    if (err.response) {
                        this.onError(err.response.data.message)
                    }
                });
        },
        onSuccess(message) {
            this.$buefy.notification.open({
                message: message,
                type: 'is-success is-light',
                duration: 5000
            })
            if (this.total < this.per_page) {
                this.$store.dispatch('invoices/loadData', {page: 1})
            }
            this.loading = false;
            this.invoice = {};
            this.$router.push('/@/invoices');
        },
        onError(response) {
            this.loading = false;
            this.$buefy.notification.open({
                message: response.data.message,
                type: 'is-danger is-light',
                duration: 5000
            })
        }
    }
}
</script>
