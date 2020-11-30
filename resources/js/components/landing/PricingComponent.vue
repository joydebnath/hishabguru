<template>
    <div class="w-full max-w-6xl m-auto flex flex-col my-20 py-6 px-6">
        <div class="pb-8">
            <h1 class="text-4xl font-semibold leading-8 text-center">
                Simple no-tricks pricing
            </h1>
        </div>
        <div class="shadow-sm border w-full rounded-md bg-opacity-50 bg-gray-100">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-8 py-6 px-8 bg-white">
                    <p
                        class="border-b pb-4 font-semibold tracking-wide flex flex-row items-center text-blue-500 text-opacity-75"
                    >
                        <Announcement/>
                        What's Included
                    </p>
                    <div class="grid grid-cols-2 gap-4 pt-6">
                        <div class="col-span-2 md:col-span-1">
                            <Feature line="Unlimited Products"/>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <Feature line="Unlimited Invoices"/>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <Feature line="Unlimited Quotations"/>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <Feature line="Unlimited Users with Roles"/>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <Feature line="Track Bills and Expenses"/>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <Feature line="Manage Orders"/>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <Feature line="Store Customer and Supplier details"/>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <Feature line="Business Operational Statistics"/>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-4 py-6 px-8 m-auto text-center">
                    <div class="flex flex-col">
                        <div class="relative">
                          <span class="text-4xl font-bold text-gray-800 line-through">
                              ৳ 750
                          </span>
                            <span
                                class="text-2xl suppercase font-bold text-indigo-500 text-opacity-75 absolute uppercase -ml-2"
                                style="top:-12px;"
                            >
                                Free*
                            </span>
                            <span class="text-sm font-semibold uppercase text-gray-700">Monthly</span>
                        </div>
                        <div>
                            <a href="https://www.hishabguru.com/register">
                                <button class="px-6 py-2 bg-gray-800 text-white font-medium rounded-md">
                                    Get Access
                                </button>
                            </a>
                        </div>
                        <small class="mt-2 text-teal-500">* Free until 31 March 2021</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Announcement from "./icons/Announcement";
import Feature from "./Feature";

export default {
    name: "PricingComponent",
    components: {Announcement, Feature}
}
</script>

<style scoped>

</style>
