<template>
    <section class="flex flex-row w-full py-4 px-4 border-t">
        <div class="grid grid-cols-6 gap-4 w-full">
            <div class="col-span-2">
                <span class="tag mb-2">
                    <small class="text-xs font-semibold tracking-wider">FOR</small>
                </span>
                <h3 class="mb-1">Meghomitra</h3>
                <div class="flex flex-col">
                    <p class="text-gray-600 text-xs tracking-wider">12 Fleming Drive</p>
                    <p class="text-gray-600 text-xs tracking-wider">Campbelltown</p>
                    <p class="text-gray-600 text-xs tracking-wider">NSW, 2560</p>
                    <p class="text-gray-600 text-xs tracking-wider">Australia</p>
                </div>
            </div>
            <div class="col-span-2">
                <div class="flex flex-col">
                    <p class="text-gray-600 text-xs text-right  tracking-wider">Total Amount</p>
                    <p class="text-gray-800 mb-0 text-right mb-4 font-semibold">1,510 BDT</p>
                    <p class="text-gray-600 text-xs text-right tracking-wider">Total Paid</p>
                    <p class="text-gray-800 mb-0 text-right mb-2 font-semibold">0 BDT</p>
                </div>
            </div>
            <div class="col-span-2">
                <div class="flex flex-col">
                    <p class="text-gray-600 text-xs text-right tracking-wider">Total Due</p>
                    <p class="text-gray-800 mb-0 text-2xl font-medium text-right">1,510 BDT</p>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "ClientBox"
}
</script>

<style scoped>

</style>
