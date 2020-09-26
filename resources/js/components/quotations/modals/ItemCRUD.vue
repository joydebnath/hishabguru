<template>
    <b-modal
        v-model="$props.show"
        has-modal-card
        :on-cancel="() => $emit('on-close')"
        :can-cancel="['x','escape']"
        trap-focus
        aria-role="dialog"
        aria-modal
        width="1000"
    >
        <b-loading :is-full-page="false" v-model="$props.loading" :can-cancel="false"/>
        <div class="modal-card" style="width: 75rem">
            <header class="modal-card-head flex flex-row justify-between">
                <p class="text-lg text-gray-700" v-text="title"></p>
                <button type="button" class="delete" @click="$emit('on-close')"/>
            </header>
            <section class="modal-card-body">

            </section>
            <FooterActions
                :action_type="$props.action_type"
                @on-save-as-draft="handleDraft"
                @on-save="handleSave"
                @on-save-for-approval="handleSaveForApproval"
            />
        </div>
    </b-modal>
</template>

<script>
import {mapGetters} from 'vuex';
import QuotationDetails from '../widgets/QuotationDetails';
import ProductsTable from '../widgets/ProductsTable';
import FooterActions from "../widgets/FooterActions";
import {store, update} from '../repo/index';

export default {
    props: {
        show: Boolean,
        action_type: String,
        loading: Boolean,
        item: Object | Array,
    },
    components: {
        FooterActions,
        QuotationDetails, ProductsTable
    },
    data() {
        return {
            error_container: false,
            error_message: '',
            quotation: {}
        }
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant',
            total: 'quotations/getTotal',
            per_page: 'getPerPage'
        }),
        title() {
            return this.$props.action_type == "edit"
                ? "Edit Quotation"
                : "Create new Quotation";
        },
        computed_item() {
            if (this.$props.item) {
                return {...this.$props.item}
            }
            return this.quotation
        }
    },
    methods: {
        loading_event(value) {
            this.$emit('on-loading', value)
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
            quotation['tenant_id'] = this.tenant_id;

            if (this.action_type === 'add') {
                this.createQuotation(quotation, 'Quotation Draft is created')
            } else {
                this.updateQuotation(quotation, 'Quotation Draft is updated')
            }
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
                quotation['status'] = 'save';
                quotation['tenant_id'] = this.tenant_id;
                if (this.action_type === 'add') {
                    this.createQuotation(quotation, 'Quotation is created')
                } else {
                    this.updateQuotation(quotation, 'Quotation is updated')
                }
            }
        },
        handleSaveForApproval() {
            console.log('approve')
        },
        createQuotation(quotation, message) {
            store(quotation)
                .then(({data}) => {
                    this.onSuccess(message)
                })
                .catch(err => {
                    if (err.response) {
                        this.onError(err.response.data.message)
                    }
                });
        },
        updateQuotation(quotation, message) {
            update(quotation.id, quotation)
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
            this.quotation = {};
            this.$emit('on-close');
            this.$buefy.notification.open({
                message: message,
                type: 'is-success is-light'
            })
            if (this.total < this.per_page) {
                this.$store.dispatch('quotations/loadData', {page: 1})
            }
        },
        onError(response) {
            this.$buefy.notification.open({
                message: response.data.message,
                type: 'is-danger is-light'
            })
        }
    }
};
</script>


