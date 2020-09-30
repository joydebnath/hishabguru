<template>
    <div class="max-w-6xl m-auto w-full mb-6 py-2">
        <Breadcrumb active_link_name="New Purchase Order"/>
        <div class="box pt-6 pb-0">
            <b-loading :is-full-page="false" v-model="loading" :can-cancel="false"/>
            <HeaderActions v-if="false" :show_option="false" :show_print="false"/>
            <div class="grid grid-cols-3 gap-2">
                <div class="col-span-1">
                    <PurchaseDetails ref="part1" :item="computed_item"/>
                </div>
                <div class="col-span-2 ml-4">
                    <ProductsTable ref="part2" :item="computed_item"/>
                    <div class="mx-12 mt-4">
                        <b-message
                            type="is-danger"
                            size="is-small"
                            :auto-close="true"
                            :duration="2000"
                            v-model="error_container"
                        >
                            <span class="tracking-wider" v-text="error_message"></span>
                        </b-message>
                    </div>
                </div>
            </div>
            <FooterActions
                cancel_route="/@/purchases"
                @on-save-as-draft="handleDraft"
                @on-save="handleSave"
                @on-save-for-approval="handleSaveForApproval"
            />
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import PurchaseDetails from "./widgets/PurchaseDetails";
import ProductsTable from "./widgets/ProductsTable";
import Breadcrumb from "./widgets/Breadcrumb";
import FooterActions from "@/components/global/crud/FooterActions";
import {store} from "./repo";
import HeaderActions from "./widgets/HeaderActions";

export default {
    name: "CreatePurchaseComponent",
    components: {HeaderActions, Breadcrumb, FooterActions, ProductsTable, PurchaseDetails},
    data() {
        return {
            error_container: false,
            error_message: '',
            order: {},
            loading: false
        }
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant',
            total: 'purchases/getTotal',
            per_page: 'getPerPage'
        }),
        computed_item() {
            return this.order
        }
    },
    methods: {
        handleDraft() {
            let order = {};
            _.forEach(this.$refs, value => {
                let {data} = value.collectData({validate: false});
                order = {...order, ...data}
            });

            if (order.purchase_order_number == null) {
                this.error_container = true;
                this.error_message = 'Purchase Order number can not be empty!';
                return;
            }

            order['status'] = 'draft';
            this.createPurchaseOrder(order, 'Purchase Order Draft is created')
        },
        handleSave() {
            let order = {}, error_bag = {};
            _.forEach(this.$refs, value => {
                let {data, errors} = value.collectData({validate: true});
                order = {...order, ...data}
                error_bag = {...error_bag, ...errors}
            });

            if (error_bag['products']) {
                this.error_container = true
                this.error_message = 'Products list can not be empty!'
            }

            if (_.isEmpty(error_bag)) {
                order['status'] = 'save';
                this.createPurchaseOrder(order, 'Purchase Order is created')
            }
        },
        handleSaveForApproval() {
            console.log('approve')
        },
        createPurchaseOrder(order, message) {
            store({...order, tenant_id: this.tenant_id})
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
            this.order = {};
            this.$buefy.notification.open({
                message: message,
                type: 'is-success is-light',
                duration: 3000
            })
            if (this.total < this.per_page) {
                this.$store.dispatch('purchases/loadData', {page: 1})
            }
            this.$router.push('/@/purchases');
        },
        onError(response) {
            this.$buefy.notification.open({
                message: response.data.message,
                type: 'is-danger is-light',
                duration: 3000
            })
        }
    }
}
</script>
