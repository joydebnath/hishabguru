<template>
    <div class="max-w-6xl m-auto w-full mb-6 py-2">
        <Breadcrumb active_link_name="New Bill"/>
        <div class="box pt-6 pb-0">
            <b-loading :is-full-page="false" v-model="loading" :can-cancel="false"/>
            <HeaderActions v-if="false" :show_option="false" :show_print="false"/>
            <div class="grid grid-cols-7 gap-2">
                <div class="col-span-2">
                    <BillDetails ref="part1" :item="computed_item"/>
                </div>
                <div class="col-span-5 ml-4">
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
                cancel_route="/@/bills"
                @on-save-as-draft="handleDraft"
                @on-save="handleSave"
                @on-save-for-approval="handleSaveForApproval"
            />
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import BillDetails from "./widgets/BillDetails";
import ProductsTable from "./widgets/ProductsTable";
import Breadcrumb from "./widgets/Breadcrumb";
import FooterActions from "@/components/global/crud/FooterActions";
import {store} from "@/repos/bills";
import HeaderActions from "./widgets/HeaderActions";

export default {
    name: "CreateBillComponent",
    components: {HeaderActions, Breadcrumb, FooterActions, ProductsTable, BillDetails},
    data() {
        return {
            error_container: false,
            error_message: '',
            bill: {},
            loading: false
        }
    },
    mounted() {
        axios
            .get('/generate-number/bills')
            .then(({data}) => {
                this.bill = {...this.bill, bill_number: data.data.number}
            })
            .catch(err => {
                console.log(err)
            })
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant',
            total: 'bills/getTotal',
            per_page: 'getPerPage'
        }),
        computed_item() {
            return this.bill
        }
    },
    methods: {
        handleDraft() {
            let bill = {};
            _.forEach(this.$refs, value => {
                let {data} = value.collectData({validate: false});
                bill = {...bill, ...data}
            });

            if (bill.bill_number == null) {
                this.error_container = true;
                this.error_message = 'Bill number can not be empty!';
                return;
            }

            bill['status'] = 'draft';
            this.createBill(bill, 'Bill Draft is created')
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
                bill['status'] = 'due';
                this.createBill(bill, 'Bill is created')
            }
        },
        handleSaveForApproval() {
            console.log('awaiting-for-approve')
        },
        createBill(bill, message) {
            this.loading = true;
            store({...bill, tenant_id: this.tenant_id})
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
            this.loading = false;
            this.bill = {};
            if (this.total < this.per_page) {
                this.$store.dispatch('bills/loadData', {page: 1})
            }
            this.$router.push('/@/bills');
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
