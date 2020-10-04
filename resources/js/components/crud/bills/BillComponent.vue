<template>
    <div class="max-w-6xl m-auto w-full mb-6 py-2">
        <Breadcrumb :active_link_name="breadcrumb_link_name"/>
        <section class="box pt-6 pb-0">
            <b-loading :is-full-page="false" v-model="loading" :can-cancel="false"/>
            <HeaderActions @on-add-payment="handleAddPayment" @on-delete="handleDelete"/>
            <div class="grid grid-cols-3 gap-2">
                <div class="col-span-1">
                    <BillDetails ref="part1" :item="computed_item"/>
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
                    <div class="flex flex-row align-items-center justify-content-between w-full" v-if="!loading">
                        <b-button
                            :type="show_payment_history ? 'is-info': 'is-info is-light'"
                            @click="handleReadPH"
                            v-text="payment_history_action_text"
                        />
                        <div class="font-medium" v-if="bill.total_due">
                            Total Due: <span class="text-red-600">{{ bill.total_due }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <FooterActions
                cancel_route="/@/bills"
                @on-save-as-draft="handleDraft"
                @on-save="handleSave"
                @on-save-for-approval="handleSaveForApproval"
                :hide_draft="hide_draft_option"
            />
        </section>

        <b-sidebar
            type="is-light"
            :fullheight="true"
            :overlay="false"
            :right="true"
            class="r-sidebar"
            v-model="show_payment_history"
            :can-cancel="['escape']"
        >
            <PaymentHistories
                :histories="computed_payment_histories"
                :loading="computed_loading_payment_histories"
                @on-loading="toggleLoadingPH"
                @on-delete="handleDeletePH"
            />
        </b-sidebar>
        <AddPaymentRecord
            :show="show_add_payment"
            :due_amount="bill.total_due"
            @on-close="show_add_payment = false"
            @on-add-record="handleAddPaymentRecord"
        />
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import BillDetails from "./widgets/BillDetails.vue";
import ProductsTable from "./widgets/ProductsTable";
import {update, read} from "@/repos/bills";
import HeaderActions from "./widgets/HeaderActions";
import Breadcrumb from "./widgets/Breadcrumb";
import FooterActions from "@/components/global/crud/FooterActions";
import PaymentHistories from "./widgets/PaymentHistories";
import AddPaymentRecord from "./widgets/AddPaymentRecord";
import headerActionsMixin from './mixins/header-actions'
import PaymentHistoriesMixin from './mixins/payment-histories'

export default {
    name: "BillComponent",
    components: {
        AddPaymentRecord, PaymentHistories, Breadcrumb, FooterActions, HeaderActions, ProductsTable, BillDetails
    },
    mixins: [headerActionsMixin, PaymentHistoriesMixin],
    mounted() {
        this.loading = true;
        read(this.$route.params.id)
            .then(({data}) => {
                this.loading = false;
                this.bill = data.data
            })
            .catch(err => {
                this.loading = false;
                this.$router.push('/@/bills');
            })
    },
    data() {
        return {
            error_container: false,
            error_message: '',
            bill: {},
            loading: false,
        }
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant',
            total: 'bills/getTotal',
            per_page: 'getPerPage'
        }),
        computed_item() {
            return this.bill
        },
        breadcrumb_link_name() {
            return this.bill ? 'Bill# ' + this.bill.bill_number : '---'
        },
        hide_draft_option() {
            return this.bill && this.bill.status !== 'draft';
        },
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
                this.error_message = 'Bill number can not be empty!';
                return;
            }

            order['status'] = 'draft';
            this.updateOrder(order, 'Bill Draft is updated')
        },
        handleSave() {
            let bill = {}, error_bag = {};
            _.forEach(this.$refs, value => {
                let {data, errors} = value.collectData({validate: true});
                bill = {...bill, ...data}
                error_bag = {...error_bag, ...errors}
            });

            if (error_bag['products']) {
                this.error_container = true
                this.error_message = 'Products list can not be empty!'
            }

            if (_.isEmpty(error_bag)) {
                this.updateOrder(bill, 'Bill is updated')
            }
        },
        handleSaveForApproval() {
            console.log('approve')
        },
        updateOrder(bill, message) {
            update(bill.id, {...bill, tenant_id: this.tenant_id})
                .then(({data}) => {
                    this.onSuccess(message)
                })
                .catch(err => {
                    if (err.response) {
                        this.onError(err.response.data.message)
                    }
                })
        },
        onSuccess(message) {
            this.bill = {};
            this.$emit('on-close');
            this.$buefy.notification.open({
                message: message,
                type: 'is-success is-light',
                duration: 5000
            })
            if (this.total < this.per_page) {
                this.$store.dispatch('bills/loadData', {page: 1})
            }

            this.$router.push('/@/bills');
        },
        onError(response) {
            this.$buefy.notification.open({
                message: response.data.message,
                type: 'is-danger is-light',
                duration: 5000
            })
        },
    },
}
</script>

<style>
.r-sidebar .sidebar-content {
    width: 300px !important;
}
</style>
