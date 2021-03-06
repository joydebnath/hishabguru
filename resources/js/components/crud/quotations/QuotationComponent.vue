<template>
    <div class="max-w-6xl m-auto w-full mb-6 py-2">
        <Breadcrumb :active_link_name="breadcrumb_link_name"/>
        <div class="box pt-6 pb-0">
            <b-loading :is-full-page="false" v-model="loading" :can-cancel="false"/>
            <HeaderActions :quotation="computed_item" @on-loading="handleLoading" @on-update="handleUpdate"/>
            <div class="grid grid-cols-7">
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
                :hide_draft="computed_item.status !== 'draft'"
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
import {update, read} from "@/repos/quotations";
import FooterActions from "@/components/global/crud/FooterActions";
import Breadcrumb from "./widgets/Breadcrumb";
import QuotationDetails from "./widgets/QuotationDetails";
import HeaderActions from "./widgets/HeaderActions";

export default {
    name: "QuotationComponent",
    components: {HeaderActions, QuotationDetails, Breadcrumb, FooterActions, ProductsTable},
    mounted() {
        this.loading = true;
        read(this.$route.params.id)
            .then(({data}) => {
                this.loading = false;
                this.quotation = data.data
            })
            .catch(err => {
                this.loading = false;
                this.$router.push('/@/quotations')
            })
    },
    data() {
        return {
            error_container: false,
            error_message: '',
            quotation: {},
            loading: false
        }
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant',
            total: 'quotations/getTotal',
            per_page: 'getPerPage'
        }),
        computed_item() {
            return this.quotation
        },
        breadcrumb_link_name() {
            return this.quotation ? 'Quotation# ' + this.quotation.quotation_number : '---'
        }
    },
    methods: {
        handleLoading(value) {
            this.loading = value
        },
        handleUpdate(data){
            this.quotation = {...data}
        },
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
            this.updateQuotation(quotation, 'Quotation Draft is updated')
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
                this.updateQuotation(quotation, 'Quotation is updated')
            }
        },
        handleSaveForApproval() {
            console.log('awaiting-approval')
        },
        updateQuotation(quotation, message) {
            update(quotation.id, {...quotation, tenant_id: this.tenant_id})
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
                duration: 5000,
            })

            this.quotation = {};
            this.$router.push('/@/quotations');
        },
        onError(response) {
            this.$buefy.notification.open({
                message: response.data.message,
                type: 'is-danger is-light',
                duration: 5000
            })
        }
    }
}
</script>
