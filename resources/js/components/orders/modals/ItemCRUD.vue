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
                <div class="grid grid-cols-3 gap-2">
                    <div class="col-span-1">
                        <OrderDetails ref="part1" :item="computed_item"/>
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
import OrderDetails from '../widgets/OrderDetails';
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
        OrderDetails,
        ProductsTable
    },
    data() {
        return {
            error_container: false,
            error_message: '',
            order: {}
        }
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant',
            total: 'orders/getTotal',
            per_page: 'getPerPage'
        }),
        title() {
            return this.$props.action_type == "edit"
                ? "Edit Order"
                : "Create new Order";
        },
        computed_item() {
            if (this.$props.item) {
                return {...this.$props.item}
            }
            return this.order
        }
    },
    methods: {
        loading_event(value) {
            this.$emit('on-loading', value)
        },
        handleDraft() {
            let order = {};
            _.forEach(this.$refs, value => {
                let {data} = value.collectData({validate: false});
                order = {...order, ...data}
            });

            if (order.order_number == null) {
                this.error_container = true;
                this.error_message = 'Order number can not be empty!';
                return;
            }

            order['status'] = 'draft';
            order['tenant_id'] = this.tenant_id;

            if (this.action_type === 'add') {
                this.createOrder(order, 'Order Draft is created')
            } else {
                this.updateOrder(order, 'Order Draft is updated')
            }
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
                order['tenant_id'] = this.tenant_id;
                if (this.action_type === 'add') {
                    this.createOrder(order, 'Order is created')
                } else {
                    this.updateOrder(order, 'Order is updated')
                }
            }
        },
        handleSaveForApproval() {
            console.log('approve')
        },
        createOrder(order, message) {
            store(order)
                .then(({data}) => {
                    this.onSuccess(message)
                })
                .catch(err => {
                    if (err.response) {
                        this.onError(err.response.data.message)
                    }
                });
        },
        updateOrder(order, message) {
            update(order.id, order)
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
            this.order = {};
            this.$emit('on-close');
            this.$buefy.notification.open({
                message: message,
                type: 'is-success is-light'
            })
            if (this.total < this.per_page) {
                this.$store.dispatch('orders/loadData', {page: 1})
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


