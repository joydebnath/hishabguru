<template>
    <section class="flex flex-row w-full py-4 px-4 border-t">
        <div class="grid grid-cols-6 gap-4 w-full">
            <div class="col-span-2">
                <span class="tag mb-2">
                    <small class="text-xs font-semibold tracking-wider">FOR</small>
                </span>
                <h3 class="mb-1">{{ $props.to.name }}</h3>
                <div class="flex flex-col">
                    <p class="text-gray-600 text-xs tracking-wider">{{ $props.to.address }}</p>
                    <p class="text-gray-600 text-xs tracking-wider">{{ $props.to.city }}</p>
                    <p class="text-gray-600 text-xs tracking-wider">{{ $props.to.state }}, {{ $props.to.postcode }}</p>
                    <p class="text-gray-600 text-xs tracking-wider">{{ $props.to.country }}</p>
                </div>
            </div>
            <div class="col-span-2">
                <div class="flex flex-col">
                    <p class="text-gray-600 text-xs text-right tracking-wider">Payment Terms</p>
                    <p class="text-gray-800 mb-0 text-right mb-2 font-semibold text-capitalize">
                        {{ $props.quotation.payment_condition }}</p>
                    <p class="text-gray-600 text-xs text-right  tracking-wider">Discount Amount</p>
                    <p class="text-gray-800 mb-0 text-right mb-4 font-semibold">
                        {{ total_discount }}
                        <span class="uppercase">{{ $props.currency }}</span>
                    </p>
                </div>
            </div>
            <div class="col-span-2">
                <div class="flex flex-col">
                    <p class="text-gray-600 text-xs text-right tracking-wider">Total Amount</p>
                    <p class="text-gray-800 mb-0 text-2xl font-medium text-right">
                        {{ $props.quotation.total_amount }}
                        <span class="uppercase">
                            {{ $props.currency }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "ClientBox",
    props: {
        currency: String,
        quotation: Array | Object,
        products: Array | Object,
        to: Array | Object,
    },
    computed: {
        total_discount() {
            const total_price = _.sumBy(this.products, value => (parseInt(value.quantity) * parseFloat(value.selling_price)))
            return total_price - parseFloat(this.$props.quotation.total)
        }
    }
}
</script>

<style scoped>

</style>
