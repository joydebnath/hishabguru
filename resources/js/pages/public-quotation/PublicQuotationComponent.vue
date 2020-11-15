<template>
    <section>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand flex flex-row items-center p-0">
                    <template v-if="logo">
                        <img :src="logo" alt="logo" class="d-inline" style="width: 110px"/>
                    </template>
                </a>
            </div>
        </nav>
        <main class="max-w-6xl mx-auto ">
            <div class="grid grid-cols-7 gap-4">
                <div class="col-span-5 pt-5">
                    <div class="flex flex-row justify-content-between align-items-center px-2 ">
                        <h1 class="text-xl font-medium tracking-wider leading-tight text-gray-700 uppercase">
                            Quotation# {{ quotation.quotation_number }}
                        </h1>
                        <span class="tag is-dark tracking-wider upper leading-6 font-medium uppercase">
                            {{ quotation.status }}
                        </span>
                    </div>
                    <div class="box mt-4">
                        <SupplierBox :quotation="quotation" :from="from"/>
                        <ClientBox :quotation="quotation" :to="to" :products="products" :currency="$props.currency"/>
                        <QuotationItems :products="products" :currency="$props.currency"/>
                    </div>
                </div>
                <div class="col-span-2 pt-10 mt-5">
                    <div class="box">
                        <HeaderActions :quotation="quotation" class="-mt-2"/>
                        <div class="grid grid-cols-3 border-t pt-2 mt-2">
                            <div class="col-span-1">
                                <div class="pb-2">
                                    <!--                                    <img src="http://hg.test/images/logo.png" alt="logo" class="d-inline"-->
                                    <!--                                         style="width: 110px"/>-->
                                </div>
                            </div>
                            <div class="col-span-2">
                                <div class="flex flex-col -mx-4 px-4">
                                    <p class="text-gray-600 text-xs text-right tracking-wider">Issue By</p>
                                    <p class="text-gray-800 mb-0 text-sm text-right mb-2 ">{{ issued_by.name }}</p>
                                    <p class="text-gray-600 text-xs text-right tracking-wider">Email</p>
                                    <p class="text-gray-800 mb-0 text-sm text-right mb-2 ">{{ issued_by.email }}</p>
                                </div>
                            </div>
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
import QuotationItems from "./QuotationItems";

export default {
    name: "PublicQuotationComponent",
    components: {QuotationItems, ClientBox, SupplierBox, HeaderActions},
    props: {
        logo: String,
        from_: String,
        for_: String,
        quotation_: String,
        products_: String,
        issued_by_: String,
        currency: String,
    },
    data() {
        return {
            from: null,
            to: null,
            quotation: null,
            products: null,
            issued_by: null,
        }
    },
    beforeMount() {
        this.from = JSON.parse(this.$props.from_)
        this.to = JSON.parse(this.$props.for_)
        this.quotation = JSON.parse(this.$props.quotation_)
        this.products = JSON.parse(this.$props.products_)
        this.issued_by = JSON.parse(this.$props.issued_by_)
    }
}
</script>

<style scoped>

</style>
