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
                <b-field label="Category Name">
                    <b-input v-model="computed_item.name"></b-input>
                </b-field>

                <b-field label="Parent Category Name">
                    <b-select placeholder="Select Parent Category" expanded v-model="computed_item.parent_id">
                        <option
                            v-for="product_category in computed_product_categories"
                            :key="product_category.id"
                            :value="product_category.id"
                            v-text="product_category.name"
                        ></option>
                    </b-select>
                </b-field>

                <b-field label="Note">
                    <b-input type="textarea" v-model="computed_item.note"></b-input>
                </b-field>
            </section>
            <footer class="modal-card-foot flex justify-content-end">
                <button class="button is-primary" @click="handleSave">Save</button>
            </footer>
        </div>
    </b-modal>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
    props: {
        show: Boolean,
        action_type: String,
        item: Object | Array,
        loading: Boolean
    },
    data() {
        return {
            category: {
                id: '',
                name: '',
                parent_id: '',
                note: ''
            },
        }
    },
    methods: {
        loading_event(value) {
            this.$emit('on-loading', value)
        },
        handleSave() {
            if (this.$props.action_type === "edit") {
                this.update();
                return 0;
            }
            this.create()
        },
        update() {
            this.loading_event(true);
            axios
                .put('/product-categories/' + this.computed_item.id, this.computed_item)
                .then(({data}) => {
                    this.loading_event(false);
                    this.$store.commit('product_categories/update', {product_category: data.data})
                    this.category = data.data
                    this.$emit('on-close')
                    this.$buefy.notification.open({
                        message: 'Product Category has been updated',
                        type: 'is-success'
                    })
                })
                .catch(err => {
                    this.loading_event(false);
                    this.$buefy.notification.open({
                        message: 'Product Category update failed',
                        type: 'is-danger'
                    })
                })
        },
        create() {
            this.loading_event(true);
            axios
                .post('/product-categories', this.computed_item)
                .then(({data}) => {
                    this.loading_event(false);
                    this.product_categories = [];
                    this.$emit('on-close');
                    this.$buefy.notification.open({
                        message: 'Product Category is created',
                        type: 'is-success'
                    })
                    if (this.total < this.per_page) {
                        this.$store.dispatch('product_categories/loadData', {page: 1})
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
            product_categories: 'filters/getProductCategories',
            total: 'product_categories/getTotal',
            per_page:'getPerPage'
        }),
        title() {
            return this.$props.action_type == "edit"
                ? "Edit Product Category"
                : "Add new Product Category";
        },
        computed_item() {
            if (this.$props.item) {
                this.category = {...this.$props.item}
            }
            return this.category
        },
        computed_product_categories() {
            if (this.$props.item) {
                return _.filter(this.product_categories, value => value.id !== this.$props.item.id)
            }
            return this.product_categories
        }
    },
};
</script>

<style></style>
