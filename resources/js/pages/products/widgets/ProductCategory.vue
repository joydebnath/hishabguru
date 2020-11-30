<template>
    <div>
        <div class="tags has-addons p-1 w-full" v-if="name">
            <div class="tag is-dark is-medium w-4/5">
                <p class="truncate mb-0 text-left">{{ name }}</p>
            </div>
            <button class="tag is-medium is-delete" @click="handleRemoveCategory"></button>
        </div>

        <b-autocomplete
            v-else
            :data="categories"
            :size="$props.size"
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
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "ProductCategory",
    props: {
        name: String,
        size: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            categories: [],
            fetching_categories: false,
        }
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant',
        }),
    },
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
