<template>
    <div>
        <p class="text-gray-900 text-base font-medium mb-1">{{ name }}</p>
        <p class="text-sm text-gray-600 mb-1 flex items-center">
            <span v-if="mobile">{{ mobile }}</span>
            <span v-if="email">&nbsp;| {{ email }}</span>
        </p>
        <p class="text-sm text-gray-600 mb-1 flex items-center">
            {{ address }}
        </p>
    </div>
</template>

<script>
export default {
    name: "SupplierTile",
    props: {
        supplier: Object | Array
    },
    computed: {
        name() {
            return this.$props.supplier.option.name ? this.$props.supplier.option.name : ''
        },
        mobile() {
            return this.$props.supplier.option.mobile ? this.$props.supplier.option.mobile : ''
        },
        email() {
            return this.$props.supplier.option.email ? this.$props.supplier.option.email : ''
        },
        address() {
            return this.$props.supplier.option.formatted_address ? this.$props.supplier.option.formatted_address : ''
        },
    }
}
</script>
