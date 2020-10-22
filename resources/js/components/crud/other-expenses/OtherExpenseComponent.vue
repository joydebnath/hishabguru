<template>
    <div class="max-w-6xl m-auto w-full mb-6 py-2">
        <Breadcrumb :active_link_name="breadcrumb_link_name"/>
        <section class="box pt-6 pb-0">
            <b-loading :is-full-page="false" v-model="loading" :can-cancel="false"/>
            <HeaderActions
                :order="computed_item"
                @on-loading="handleLoading"
                @on-update="handleUpdate"
                @on-add-payment="handleAddPayment"
                @on-delete="handleDelete"
            />
            <div class="grid grid-cols-7 gap-2">
                <div class="col-span-2">
                    <ExpenseDetails ref="part1" :item="computed_item"/>
                </div>
                <div class="col-span-5 ml-4">
                    <ProductsTable
                        ref="part2"
                        :editable="!not_editable"
                        :item="computed_item"
                        @on-add-product="handleAddProduct"
                    />
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
                    <br>
                    <div class="flex flex-col w-full" v-if="!loading">
                        <div
                            class="font-medium align-items-center text-right px-8"
                            v-if="is_not_draft"
                        >
                            Total Due: <span class="text-red-600">{{ expense.total_due }}</span>
                        </div>
                        <div class="w-100">
                            <PaymentHistories
                                currency="BDT"
                                :payment_histories="computed_payment_histories"
                                @on-delete="handleDeletePH"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <FooterActions
                cancel_route="/@/other-expenses"
                @on-save-as-draft="handleDraft"
                @on-save="handleSave"
                @on-save-for-approval="handleSaveForApproval"
                :hide_draft="hide_draft_option"
            />
        </section>
        <AddPaymentRecord
            :show="show_add_payment"
            :due_amount="computed_total_due"
            @on-close="show_add_payment = false"
            @on-add-record="handleAddPaymentRecord"
        />
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import ExpenseDetails from "./widgets/ExpenseDetails.vue";
import ProductsTable from "./widgets/ProductsTable";
import {update, read} from "@/repos/other-expenses";
import HeaderActions from "./widgets/HeaderActions";
import Breadcrumb from "./widgets/Breadcrumb";
import FooterActions from "@/components/global/crud/FooterActions";
import AddPaymentRecord from "./widgets/AddPaymentRecord";
import headerActionsMixin from './mixins/header-actions'
import paymentHistoriesMixin from './mixins/payment-histories'
import PaymentHistories from "./widgets/PaymentHistories";

export default {
    name: "ExpenseComponent",
    components: {
        PaymentHistories, AddPaymentRecord, Breadcrumb, FooterActions, HeaderActions, ProductsTable, ExpenseDetails
    },
    mixins: [headerActionsMixin, paymentHistoriesMixin],
    mounted() {
        this.loading = true;
        read(this.$route.params.id)
            .then(({data}) => {
                this.loading = false;
                this.expense = data.data
                this.payment_histories = this.expense.payment_histories
                delete this.expense.payment_histories
            })
            .catch(err => {
                this.loading = false;
                this.$router.push('/@/other-expenses');
            })
    },
    data() {
        return {
            error_container: false,
            error_message: '',
            expense: {},
            loading: false,
        }
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant',
            total: 'other_expenses/getTotal',
            per_page: 'getPerPage'
        }),
        computed_item() {
            return this.expense
        },
        breadcrumb_link_name() {
            return this.expense ? 'Expense# ' + this.expense.expense_number : '---'
        },
        hide_draft_option() {
            var STATUSES = ['save-for-approval', 'due', 'paid']
            return this.expense && STATUSES.includes(this.expense.status);
        },
        is_not_draft() {
            return this.expense && this.expense.status !== 'draft';
        },
        not_editable() {
            const STATUSES = ['due', 'paid'];
            return this.expense && STATUSES.includes(this.expense.status);
        }
    },
    methods: {
        handleLoading(value) {
            this.loading = value
        },
        handleUpdate(data){
            this.expense = {...data}
        },
        handleDraft() {
            let order = {};
            _.forEach(this.$refs, value => {
                let {data} = value.collectData({validate: false});
                order = {...order, ...data}
            });

            if (order.purchase_order_number == null) {
                this.error_container = true;
                this.error_message = 'Expense number can not be empty!';
                return;
            }

            order['status'] = 'draft';
            this.updateOrder(order, 'Expense Draft is updated')
        },
        handleSave() {
            let expense = {}, error_bag = {};
            _.forEach(this.$refs, value => {
                let {data, errors} = value.collectData({validate: true});
                expense = {...expense, ...data}
                error_bag = {...error_bag, ...errors}
            });

            if (error_bag['products']) {
                this.error_container = true
                this.error_message = 'Products list can not be empty!'
            }

            if (_.isEmpty(error_bag)) {
                const total_paid = _.sumBy(this.payment_histories, value => parseFloat(value.amount))
                if (parseFloat(expense.total_amount) <= total_paid) {
                    expense['status'] = 'paid';
                } else {
                    expense['status'] = 'due';
                }
                this.updateOrder(expense, 'Expense is updated')
            }
        },
        handleSaveForApproval() {
            console.log('save-for-approval')
        },
        handleAddProduct({total_amount, products}) {
            const total_paid = _.sumBy(this.payment_histories, value => parseFloat(value.amount))
            this.expense = {
                ...this.expense,
                total_amount: total_amount,
                total_due: parseFloat(total_amount) - parseFloat(total_paid),
                products: products
            }
        },
        updateOrder(expense, message) {
            update(expense.id, {...expense, tenant_id: this.tenant_id})
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
            this.$buefy.notification.open({
                message: message,
                type: 'is-success is-light',
                duration: 5000
            })

            this.expense = {};
            this.$router.push('/@/other-expenses');
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
