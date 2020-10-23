<template>
    <b-tag
        v-if="name"
        class="p-1 w-32"
        type="is-dark"
        attached
        size="is-medium"
        closable
        @close="handleRemoveCategory"
    >
        {{ name }}
    </b-tag>

    <b-autocomplete
        v-else
        :data="categories"
        placeholder="Search by name"
        field="name"
        @typing="getCategories"
        @select="handleAddCategory"
        @input="handleInput"
    >
        <template slot="empty">
            <span v-if="fetching_categories">
                <b-skeleton width="100%" :animated="true"/>
            </span>
            <span v-else>
                No results found
            </span>
        </template>
    </b-autocomplete>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "ProductCategory",
    props: {
        name: String
    },
    data() {
        return {
            categories: [],
            fetching_categories: false,
        }
    },
    ...mapGetters({
        tenant_id: 'tenancy/getCurrentTenant',
    }),
    methods: {
        handleRemoveCategory() {
            this.$emit('on-remove')
        },
        handleAddCategory(value) {
            this.$emit('on-add', value)
        },
        handleInput(value) {
            if (value) {
                this.fetching_categories = true
            }
        },
        getCategories: _.debounce(function (value) {
            this.categories = []
            axios
                .get('/lookup/product-categories', {
                    params: {
                        tenant_id: this.tenant_id,
                        search: value
                    }
                })
                .then(({data}) => {
                    this.fetching_categories = false;
                    this.categories = data.data
                })
                .catch(err => {
                    this.fetching_categories = false;
                    console.log('getCategories', err)
                })
        }, 800)
    }
}
</script>

<style scoped>

</style>
