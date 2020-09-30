<template>
    <b-tag
        v-if="name"
        class="p-1 w-32"
        type="is-light"
        attached
        size="is-medium"
        closable
        @close="handleRemoveCategory"
    >
        {{ name }}
    </b-tag>

    <b-autocomplete
        v-else
        @typing="getCategories"
        :data="categories"
        placeholder="Search by name"
        field="name"
        @select="handleAddCategory"
    >
        <template slot="footer" v-if="fetching_categories">
            <b-skeleton width="100%" :animated="true"/>
        </template>
        <template slot="empty">No results found</template>
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
    methods:{
        handleRemoveCategory(){
            this.$emit('on-remove')
        },
        handleAddCategory(value){
            this.$emit('on-add', value)
        },
        getCategories(value) {
            this.fetching_categories = true;
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
        }
    }
}
</script>

<style scoped>

</style>
