<template>
    <b-modal
        v-model="$props.show"
        :on-cancel="() => $emit('on-close')"
        :can-cancel="['x','escape']"
        has-modal-card
        trap-focus
        aria-role="dialog"
        aria-modal
    >
        <b-loading :is-full-page="false" v-model="$props.loading" :can-cancel="false"/>
        <div class="modal-card" style="width: 630px">
            <header class="modal-card-head flex flex-row justify-between">
                <p class="text-lg text-gray-700" v-text="title"></p>
                <button type="button" class="delete" @click="$emit('on-close')"></button>
            </header>
            <section class="modal-card-body">
                <b-field label="Item Name">
                    <b-input v-model="computed_item.name"></b-input>
                </b-field>
                <b-field grouped>
                    <b-field label="Item Code">
                        <b-input v-model="computed_item.code"></b-input>
                    </b-field>
                    <b-field label="Category">
                        <ProductCategory :name="computed_category.name" @on-add="handleAddCategory" @on-remove="handleRemoveCategory"/>
                    </b-field>
                </b-field>
                <b-field grouped>
                    <b-field label="Buying Unit Cost">
                        <b-input v-model="computed_item.buying_cost"></b-input>
                    </b-field>
                    <b-field label="Quantity">
                        <b-input v-model="computed_item.quantity"></b-input>
                    </b-field>
                </b-field>
                <b-field grouped>
                    <b-field label="Selling Unit Price">
                        <b-input v-model="computed_item.selling_price"></b-input>
                    </b-field>
                    <b-field label="Tax rate %">
                        <b-input v-model="computed_item.tax"></b-input>
                    </b-field>
                </b-field>
                <b-field label="Description">
                    <b-input type="textarea" v-model="computed_item.description"></b-input>
                </b-field>
            </section>
            <footer class="modal-card-foot flex justify-content-end">
                <button class="button is-primary" @click="handleSave">Save</button>
            </footer>
        </div>
    </b-modal>
</template>

<script>
import {mapGetters} from 'vuex';
import ProductCategory from "../widgets/ProductCategory";

export default {
    components: {ProductCategory},
    props: {
        show: Boolean,
        action_type: String,
        item: Object | Array,
        loading: Boolean
    },
    data() {
        return {
            product: {},
        }
    },
    methods: {
        loading_event(value) {
            this.$emit('on-loading', value)
        },
        handleSave() {
            if (this.$props.action_type == "edit") {
                this.update();
                return 0;
            }
            this.create()
        },
        handleRemoveCategory() {
            this.$emit('on-update', {...this.computed_item, category: {}})
        },
        handleAddCategory(category) {
            this.$emit('on-update', {...this.computed_item, category: category})
        },
        update() {
            this.loading_event(true);
            axios
                .put('/products/' + this.computed_item.id, {
                    ...this.computed_item,
                    tenant_id: this.tenant_id
                })
                .then(({data}) => {
                    this.$store.commit('products/update', {product: data.data})
                    this.product = data.data
                    this.onSuccess('Product has been updated')
                })
                .catch(err => {
                    this.onError('Product update failed')
                })
        },
        create() {
            this.loading_event(true);
            axios
                .post('/products', {
                    ...this.computed_item,
                    tenant_id: this.tenant_id
                })
                .then(({data}) => {
                    this.onSuccess('Product is created')
                    this.product = {};

                    if (this.total < this.per_page) {
                        this.$store.dispatch('products/loadData', {page: 1})
                    }
                })
                .catch(err => {
                    this.onError('Whoops! Something went wrong...')
                })
        },
        onSuccess(message) {
            this.loading_event(false);
            this.$emit('on-close')
            this.$buefy.notification.open({
                message: 'Product ',
                type: 'is-success is-light'
            })
        },
        onError(message) {
            this.loading_event(false);
            this.$buefy.notification.open({
                message: message,
                type: 'is-danger is-light'
            })
        },

    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant',
            total: 'products/getTotal',
            per_page: 'getPerPage'
        }),
        title() {
            return this.$props.action_type == "edit"
                ? "Edit Product"
                : "Add new Product";
        },
        computed_item() {
            if (this.$props.item) {
                return {...this.$props.item}
            }
            return this.product
        },
        computed_category() {
            if (this.$props.item.category) {
                return {...this.$props.item.category}
            }
            return {}
        },
    },
};
</script>

<style></style>
