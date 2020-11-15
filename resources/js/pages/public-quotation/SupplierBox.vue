<template>
    <section class="flex flex-row w-full pb-4 pt-2 px-4">
        <div class="grid grid-cols-5 gap-4 w-full">
            <div class="col-span-3">
                <span class="tag mb-2">
                    <small class="text-xs font-semibold tracking-wider">FROM</small>
                </span>
                <h3 class="mb-1">{{ $props.from.name }}</h3>
                <div class="flex flex-col">
                    <p class="text-gray-600 text-xs tracking-wider">{{ $props.from.address }}</p>
                    <p class="text-gray-600 text-xs tracking-wider">{{ $props.from.city }}</p>
                    <p class="text-gray-600 text-xs tracking-wider">{{ $props.from.state }}, {{ $props.from.postcode }}</p>
                    <p class="text-gray-600 text-xs tracking-wider">{{ $props.from.country }}</p>
                </div>
            </div>
            <div class="col-span-2">
                <div class="flex flex-col">
                    <p class="text-gray-800 mb-0 text-sm text-right">{{ quotation.create_date }}</p>
                    <p class="text-gray-600 text-xs text-right mb-2 tracking-wider">Issue Date</p>
                    <p class="text-gray-800 mb-0 text-sm text-right">{{ quotation.expiry_date }}</p>
                    <p class="text-gray-600 text-xs text-right mb-2 tracking-wider">Expiry Date</p>
                    <p class="text-gray-800 mb-0 text-sm text-right">{{ quotation.reference_number }}</p>
                    <p class="text-gray-600 text-xs text-right tracking-wider">Reference Number</p>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "SupplierBox",
    props:{
        quotation: Array | Object,
        from: Array | Object,
    }
}
</script>

<style scoped>

</style>
