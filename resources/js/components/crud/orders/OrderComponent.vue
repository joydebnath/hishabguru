<template>
    <div class="max-w-6xl m-auto w-full mb-6 py-2">
        <Breadcrumb :active_link_name="breadcrumb_link_name"/>
        <div class="box pt-6 pb-0">
            <b-loading :is-full-page="false" v-model="loading" :can-cancel="false"/>
            <HeaderActions v-if="false"/>
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
            <FooterActions
                cancel_route="/@/orders"
                @on-save-as-draft="handleDraft"
                @on-save="handleSave"
                @on-save-for-approval="handleSaveForApproval"
            />
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import OrderDetails from "./widgets/OrderDetails";
import ProductsTable from "./widgets/ProductsTable";
import {update, read} from "@/repos/orders";
import HeaderActions from "./widgets/HeaderActions";
import Breadcrumb from "./widgets/Breadcrumb";
import FooterActions from "@/components/global/crud/FooterActions";


export default {
    name: "OrderOverview",
    components: {Breadcrumb, FooterActions, HeaderActions, ProductsTable, OrderDetails},
    mounted() {
        this.loading = true;
        read(this.$route.params.id)
            .then(({data}) => {
                this.loading = false;
                this.order = data.data
            })
            .catch(err => {
                this.loading = false;
                this.$router.push('/@/orders');
            })
    },
    data() {
        return {
            error_container: false,
            error_message: '',
            order: {},
            loading: false,
        }
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant',
            total: 'orders/getTotal',
            per_page: 'getPerPage'
        }),
        computed_item() {
            return this.order
        },
        breadcrumb_link_name() {
            return this.order ? 'Order# ' + this.order.order_number : '---'
        }
    },
    methods: {
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
            this.updateOrder(order, 'Order Draft is updated')
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
                order['status'] = 'ordered';
                this.updateOrder(order, 'Order is updated')
            }
        },
        handleSaveForApproval() {
            console.log('approve')
        },
        updateOrder(order, message) {
            this.loading = true;
            update(order.id, {...order, tenant_id: this.tenant_id})
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
            });
            this.loading = false;
            this.order = {};
            this.$router.push('/@/orders');
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
