<template>
    <div class="max-w-6xl m-auto w-full mb-6 py-2">
        <Breadcrumb active_link_name="New Expense"/>
        <div class="box pt-6 pb-0">
            <b-loading :is-full-page="false" v-model="loading" :can-cancel="false"/>
            <HeaderActions v-if="false" :show_option="false" :show_print="false"/>
            <div class="grid grid-cols-7 gap-2">
                <div class="col-span-2">
                    <OtherExpenseDetails ref="part1" :item="computed_item"/>
                </div>
                <div class="col-span-5 ml-4">
                    <ProductsTable ref="part2" :item="computed_item"/>
                    <div class="mx-12 mt-4">
                        <b-message
                            type="is-danger"
                            size="is-small"
                            :auto-close="true"
                            :duration="3500"
                            v-model="error_container"
                        >
                            <span class="tracking-wider" v-text="error_message"></span>
                        </b-message>
                    </div>
                    <br>
                </div>
            </div>
            <div class="grid grid-cols-3">
                <div class="col-start-2 col-span-2">
                    <AddInlinePaymentRecord ref="part3"/>
                </div>
            </div>
            <FooterActions
                cancel_route="/@/other-expenses"
                @on-save-as-draft="handleDraft"
                @on-save="handleSave"
                @on-save-for-approval="handleSaveForApproval"
            />
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import OtherExpenseDetails from "./widgets/ExpenseDetails";
import ProductsTable from "./widgets/ProductsTable";
import Breadcrumb from "./widgets/Breadcrumb";
import FooterActions from "@/components/global/crud/FooterActions";
import {store} from "@/repos/other-expenses";
import HeaderActions from "./widgets/HeaderActions";
import AddInlinePaymentRecord from "./widgets/AddInlinePaymentRecord";

export default {
    name: "CreateOtherExpenseComponent",
    components: {HeaderActions, Breadcrumb, FooterActions, ProductsTable, OtherExpenseDetails, AddInlinePaymentRecord},
    data() {
        return {
            error_container: false,
            error_message: '',
            expense: {},
            loading: false
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
        }
    },
    methods: {
        handleDraft() {
            let expense = {};
            _.forEach(this.$refs, value => {
                let {data} = value.collectData({validate: false});
                expense = {...expense, ...data}
            });

            if (expense.expense_number == null) {
                this.error_container = true;
                this.error_message = 'Expense number can not be empty!';
                return;
            }

            expense['status'] = 'draft';
            this.createOtherExpense(expense, 'Expense Draft is created')
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

                if (expense.payment.amount && (parseFloat(expense.total_amount) <= parseFloat(expense.payment.amount))) {
                    expense['status'] = 'paid';
                } else {
                    expense['status'] = 'due';
                }

                this.createOtherExpense(expense, 'Expense is created')
            }
        },
        handleSaveForApproval() {
            console.log('awaiting-for-approve')
        },
        createOtherExpense(expense, message) {
            this.loading = true;
            store({...expense, tenant_id: this.tenant_id})
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
                this.$store.dispatch('expenses/loadData', {page: 1})
            }
            this.loading = false;
            this.expense = {};
            this.$router.push('/@/other-expenses');
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
