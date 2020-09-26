<template>
    <div>
        <p class="text-gray-900 text-base font-medium mb-1">{{ name }}</p>
        <p class="text-sm text-gray-600 mb-1 flex items-center">
            <span v-if="mobile">{{ mobile }}</span>
            <span v-if="email"> | {{ email }}</span>
        </p>
        <p class="text-sm text-gray-600 mb-1 flex items-center">
            {{ address }}
        </p>
    </div>
</template>

<script>
export default {
    name: "ClientTile",
    props: {
        client: Object | Array
    },
    computed: {
        name() {
            return this.$props.client.option.name ? this.$props.client.option.name : ''
        },
        mobile() {
            return this.$props.client.option.mobile ? this.$props.client.option.mobile : ''
        },
        email() {
            return this.$props.client.option.email ? this.$props.client.option.email : ''
        },
        address() {
            return this.$props.client.option.formatted_address ? this.$props.client.option.formatted_address : ''
        },
    }
}
</script>
