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
        <div class="modal-card" style="width: 75rem">
            <header class="modal-card-head flex flex-row justify-between">
                <p class="text-lg text-gray-700" v-text="title"></p>
                <button type="button" class="delete" @click="$emit('on-close')"/>
            </header>
            <section class="modal-card-body">
                <div class="grid grid-cols-3 gap-2">
                    <div class="col-span-1">
                        <QuotationDetails ref="part1"/>
                    </div>
                    <div class="col-span-2 ml-4">
                        <ProductsTable ref="part2"/>
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
            </section>
            <FooterActions
                @on-save-as-draft="handleDraft"
                @on-save="handleSave"
                @on-save-for-approval="handleSaveForApproval"
            />
        </div>
    </b-modal>
</template>

<script>
import QuotationDetails from '../widgets/QuotationDetails'
import ProductsTable from '../widgets/ProductsTable'
import FooterActions from "../widgets/FooterActions";

export default {
    props: {
        show: Boolean,
        action_type: String
    },
    components: {
        FooterActions,
        QuotationDetails, ProductsTable
    },
    data() {
        return {
            error_container: false,
            error_message: '',

        }
    },
    computed: {
        title() {
            return this.$props.action_type == "edit"
                ? "Edit Quotation"
                : "Create new Quotation";
        }
    },
    methods: {
        handleDraft() {
            let quotation = {};
            _.forEach(this.$refs, value => {
                let {data} = value.collectData({validate: false});
                quotation = {...quotation, ...data}
            });

            if(quotation.quotation_number == null){
                this.error_container = true;
                this.error_message = 'Quotation number can not be empty!';
                return ;
            }
            //axios
            quotation['status'] = 'draft'
            console.log(quotation)
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
                //axios
                quotation['status'] = 'complete'
                console.log(quotation)
            }
        },
        handleSaveForApproval() {
            console.log('approve')
        }
    }
};
</script>


