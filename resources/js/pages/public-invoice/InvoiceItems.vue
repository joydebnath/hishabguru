<template>
    <section class="flex flex-row -mx-5">
        <table class="w-full">
            <thead>
            <tr>
                <th class="px-6 bg-gray-100 py-3 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider border-b">
                    Item
                </th>
                <th class="px-6 bg-gray-100 py-3 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider border-b">
                    Qty
                </th>
                <th class="px-6 bg-gray-100 py-3 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider border-b">
                    Unit price
                </th>
                <th class="px-6 bg-gray-100 py-3 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider border-b">
                    Tax
                </th>
                <th class="px-6 bg-gray-100 py-3 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider border-b">
                    Discount
                </th>
                <th class="px-6 bg-gray-100 py-3 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider border-b">
                    Total
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="(product, index) in $props.products" :key="index">
                <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                    <div class="flex flex-col">
                        {{ product.name }}
                    </div>
                    <span class="text-gray-700 text-sm">#{{ product.code }}</span>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                    {{ product.quantity }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                    {{ product.price }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                    {{ product.tax_rate }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                    {{ product.discount }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                    {{ product.total }}
                </td>
            </tr>
            </tbody>
        </table>

    </section>
</template>

<script>
export default {
    name: "InvoiceItems",
    props: {
        products: Array | Object
    }
}
</script>

<style scoped>

</style>
