<template>
    <div class="w-full bg-white max-w-6xl m-auto h-auto mt-20 mb-20">
        <div class="flex flex-row p-8 items-center justify-center pb-8 border-b">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-6 mx-12 md:mx-0">
                    <img :src="welcome" alt="rockstar"/>
                </div>
                <div class="col-span-12 md:col-span-6">
                    <h1
                        class="text-2xl md:text-4xl font-semibold text-gray-600 text-left"
                    >
                        A simple tool that helps you to
                        <strong class="text-gray-900 uppercase">grow</strong> your Online
                        <strong class="text-gray-900">Business</strong>!
                    </h1>
                    <p
                        class="text-lg md:text-xl robo tracking-wider text-gray-700 pt-4 pb-2 text-left"
                    >
                        <span class="text-xl md:text-2xl text-blue-500 font-semibold">HishabGuru</span>
                        is an inventory and account manager for small businesses. Let us
                        deal with all the complexities, so that you can focus on your
                        business.
                    </p>
                    <div class="flex flex-row-reverse pr-6">
                        <a href="https://app.hishabguru.com/register">
                            <button
                                class="px-2 py-1 md:px-3 md:py-2 text-base md:text-lg border border-gray-200 shadow-md font-medium tracking-wide bg-white text-blue-500  focus:outline-none rounded-lg my-4"
                            >
                                Try it for FREE
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <section class="max-w-4xl m-auto mt-8">
            <h1
                class="text-2xl robo font-semibold text-gray-700 tracking-wide text-center"
            >
                What can <span class="text-blue-500">We</span> do for you?
            </h1>
            <RightServiceBox
                image="/svg/2.svg"
                message="Manage Products and Inventory"
            />
            <LeftServiceBox
                image="/svg/7.svg"
                message="Manage Quotations and Orders"
            />
            <RightServiceBox
                image="/svg/4.svg"
                message="Manage and Share Order Invoices"
            />
            <LeftServiceBox
                image="/svg/1.svg"
                message="Track business Bills & Expenses"
            />
            <RightServiceBox
                image="/svg/3.svg"
                message="Track cash flow & progresses"
            />
        </section>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import RightServiceBox from "./RightServiceBox";
import LeftServiceBox from "./LeftServiceBox";

export default {
    name: "LandingComponent",
    components: {LeftServiceBox, RightServiceBox},
    computed: {
        ...mapGetters({
            welcome: 'getWelcomeBanner',
            one: 'getSvg1',
            two: 'getSvg2',
            three: 'getSvg3',
            four: 'getSvg4',
            five: 'getSvg5',
            six: 'getSvg6',
            sever: 'getSvg7',
        })
    }
}
</script>

<style scoped>

</style>
