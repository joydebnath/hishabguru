<template>
    <section>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand flex flex-row items-center p-0">
                    <template v-if="logo">
                        <b-image :src="logo" alt="logo" class="d-inline" style="width: 110px"/>
                    </template>
                </a>
            </div>
        </nav>
        <main class="max-w-6xl mx-auto ">
            <div class="grid grid-cols-7 gap-4">
                <div class="col-span-5 pt-5">
                    <div class="flex flex-row justify-content-between align-items-center px-2 ">
                        <h1 class="text-xl font-medium tracking-wider leading-tight text-gray-700 uppercase">
                            Invoice# INV-200178456
                        </h1>
                        <span class="tag is-dark tracking-wider upper leading-6 font-medium">PAID</span>
                    </div>
                    <div class="box mt-4">
                        <SupplierBox/>
                        <ClientBox/>
                        <InvoiceItems/>
                    </div>
                </div>
                <div class="col-span-2 pt-10 mt-5">
                    <div class="box">
                        <HeaderActions class="-mt-2"/>
                        <div class="flex flex-col mt-2 pt-2 -mx-4 border-t px-4">
                            <p class="text-gray-600 text-xs text-right tracking-wider">Issue By</p>
                            <p class="text-gray-800 mb-0 text-sm text-right mb-2 ">Joy Debnath</p>
                            <p class="text-gray-600 text-xs text-right tracking-wider">Email</p>
                            <p class="text-gray-800 mb-0 text-sm text-right mb-2 ">JoyDebnath@test.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </section>
</template>

<script>
import HeaderActions from "./HeaderActions";
import SupplierBox from "./SupplierBox";
import ClientBox from "./ClientBox";
import InvoiceItems from "./InvoiceItems";

export default {
    name: "PublicInvoiceComponent",
    components: {InvoiceItems, ClientBox, SupplierBox, HeaderActions},
    props: {
        logo: String
    },
}
</script>

<style scoped>

</style>
