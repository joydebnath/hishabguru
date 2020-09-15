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
                        <b-select placeholder="Select Category" expanded v-model="computed_item.category_id">
                            <option
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                                v-text="category.name"
                            ></option>
                        </b-select>
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
                    <b-field label="Tax rate">
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

export default {
    props: {
        show: Boolean,
        action_type: String,
        item: Object | Array,
        loading: Boolean
    },
    data() {
        return {
            product: {
                id: '',
                name: '',
                code: '',
                category_id: '',
                buying_cost: '',
                quantity: '',
                selling_price: '',
                tax: '',
                description: ''
            }
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
        update() {
            this.loading_event(true);
            axios
                .put('/products/' + this.computed_item.id, this.computed_item)
                .then(({data}) => {
                    this.loading_event(false);
                    this.$store.commit('products/update', {product: data.data})
                    this.product = data.data
                    this.$emit('on-close')
                    this.$buefy.notification.open({
                        message: 'Product has been updated',
                        type: 'is-success'
                    })
                })
                .catch(err => {
                    this.loading_event(false);
                    this.$buefy.notification.open({
                        message: 'Product update failed',
                        type: 'is-danger'
                    })
                })
        },
        create() {
            this.loading_event(true);
            axios
                .post('/products', this.computed_item)
                .then(({data}) => {
                    this.loading_event(false);
                    this.product = [];
                    this.$emit('on-close');
                    this.$buefy.notification.open({
                        message: 'Product is created',
                        type: 'is-success'
                    })
                    if (this.total < this.per_page) {
                        this.$store.dispatch('products/loadData', {page: 1})
                    }
                })
                .catch(err => {
                    this.loading_event(false);
                    this.$buefy.notification.open({
                        message: 'Whoops! Something went wrong...',
                        type: 'is-danger'
                    })
                })
        }
    },
    computed: {
        ...mapGetters({
            categories: 'filters/getProductCategories',
            total: 'products/getTotal',
            per_page:'getPerPage'
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
        }
    },
};
</script>

<style></style>
