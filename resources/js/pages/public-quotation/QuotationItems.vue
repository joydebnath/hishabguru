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
            <tr>
                <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                    <div class="flex flex-col">
                        A really long name with is normal
                    </div>
                    <span class="text-gray-700 text-sm">#12456</span>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                    5
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                    11,500
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                    15%
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">

                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900">
                    15,000
                </td>
            </tr>
            </tbody>
        </table>

    </section>
</template>

<script>
export default {
    name: "QuotationItems"
}
</script>

<style scoped>

</style>
