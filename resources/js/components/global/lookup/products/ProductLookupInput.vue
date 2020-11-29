<template>
    <b-autocomplete
        :data="search_results"
        placeholder="Search product by name or code"
        field="name"
        style="width: 40.7%"
        clear-on-select
        :loading="loading"
        @typing="searchProducts"
        @select="handleProductSelected"
        @input="handleInput"
        custom-class="text-sm"
    >
        <template slot-scope="props">
            <ProductTile :product="props"/>
        </template>
        <template v-slot:empty>
            No product found
        </template>
    </b-autocomplete>
</template>

<script>
import {mapGetters} from 'vuex'
import ProductTile from "./ProductTile";

export default {
    name: "ProductLookupInput",
    components: {
        ProductTile
    },
    data() {
        return {
            search_results: [],
            loading: false,
        }
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant'
        })
    },
    methods: {
        handleProductSelected(product) {
            if (product) {
                this.loading = false;
                this.$emit('on-select', product)
            }
        },
        searchProducts: _.debounce(function (value) {
            axios
                .get('/lookup/products', {
                    params: {
                        search: value,
                        tenant_id: this.tenant_id
                    }
                })
                .then(({data}) => {
                    this.loading = false;
                    this.search_results = data.data;
                })
                .catch(err => {
                    this.loading = false;
                    console.log('searchProducts => ', err)
                })
        }, 800),
        handleInput(value) {
            if (value) {
                this.loading = true
            }
        }
    }
}
</script>
