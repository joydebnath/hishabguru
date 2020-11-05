<template>
    <div class="max-w-6xl m-auto w-full mb-6 py-2">
        <Breadcrumb active_link_name="New Quotation"/>
        <div class="box pt-6 pb-0">
            <b-loading :is-full-page="false" v-model="loading" :can-cancel="false"/>
            <div class="grid grid-cols-7 gap-2">
                <div class="col-span-2">
                    <QuotationDetails ref="part1" :item="computed_item"/>
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
                cancel_route="/@/quotations"
                @on-save-as-draft="handleDraft"
                @on-save="handleSave"
                @on-save-for-approval="handleSaveForApproval"
            />
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import ProductsTable from "./widgets/ProductsTable";
import FooterActions from "@/components/global/crud/FooterActions";
import Breadcrumb from "./widgets/Breadcrumb";
import QuotationDetails from "./widgets/QuotationDetails";
import {store} from "@/repos/quotations";

export default {
    name: "CreateQuotationComponent",
    components: {QuotationDetails, Breadcrumb, FooterActions, ProductsTable},
    data() {
        return {
            error_container: false,
            error_message: '',
            quotation: {},
            loading: false
        }
    },
    mounted() {
        axios
            .get('/generate-number/quotations')
            .then(({data}) => {
                this.quotation = {...this.quotation, quotation_number: data.data.number}
            })
            .catch(err => {
                console.log(err)
            })
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant',
            total: 'quotations/getTotal',
            per_page: 'getPerPage'
        }),
        computed_item() {
            return this.quotation
        }
    },
    methods: {
        handleDraft() {
            let quotation = {};
            _.forEach(this.$refs, value => {
                let {data} = value.collectData({validate: false});
                quotation = {...quotation, ...data}
            });

            if (quotation.quotation_number == null) {
                this.error_container = true;
                this.error_message = 'Quotation number can not be empty!';
                return;
            }

            quotation['status'] = 'draft';
            this.createQuotation(quotation, 'Quotation Draft is created')
        },
        handleSave() {
            let quotation = {}, error_bag = {};
            _.forEach(this.$refs, value => {
                let {data, errors} = value.collectData({validate: true});
                quotation = {...quotation, ...data}
                error_bag = {...error_bag, ...errors}
            });

            if (error_bag['products']) {
                this.error_container = true
                this.error_message = 'Products list can not be empty!'
            }

            if (_.isEmpty(error_bag)) {
                quotation['status'] = 'open';
                this.createQuotation(quotation, 'Quotation is created')
            }
        },
        handleSaveForApproval() {
            console.log('awaiting-approval')
        },
        createQuotation(quotation, message) {
            this.loading = true;
            store({...quotation, tenant_id: this.tenant_id})
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
                duration: 3000
            })
            if (this.total < this.per_page) {
                this.$store.dispatch('quotations/loadData', {page: 1})
            }
            this.loading = false;
            this.quotation = {};
            this.$router.push('/@/quotations');
        },
        onError(response) {
            this.loading = false;
            this.$buefy.notification.open({
                message: response.data.message,
                type: 'is-danger is-light',
                duration: 3000
            })
        }
    }
}
</script>
