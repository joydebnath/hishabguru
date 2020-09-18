<template>
    <div class="mb-2">
        <p class="text-sm text-gray-600 mb-1 flex items-center">{{ code }}</p>
        <div class="text-gray-900 text-base font-medium mt-1">{{ name }}</div>
    </div>
</template>

<script>
export default {
    name: "ProductTile",
    props: {
        product: Object | Array
    },
    computed: {
        code() {
            return this.$props.product.option.code ? this.$props.product.option.code : ''
        },
        name() {
            return this.$props.product.option.name ? this.$props.product.option.name : ''
        }
    }
}
</script>

<style scoped>

</style>
