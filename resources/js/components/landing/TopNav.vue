<template>
    <div class="flex flex-row justify-between">
        <div class="ml-4 md:ml-20 mt-4">
            <router-link to="/">
                <img
                    :src="logo"
                    width="110px"
                    class="float-left"
                    alt="HishabGuru"
                />
            </router-link>
        </div>
        <div
            class="items-center flex-row-reverse py-4 px-10 poppins hidden md:flex"
        >
            <a href="/register">
                <button
                    class="px-3 py-2 border-blue-300 text-blue-500 tracking-wider rounded font-semibold mx-1 border hover:bg-blue-500 focus:outline-none hover:text-white text-xs"
                >
                    Sign up
                </button>
            </a>
            <a href="/login">
                <button
                    class="px-3 py-2 text-blue-500 tracking-wider rounded font-semibold mx-1  hover:bg-blue-500 focus:outline-none hover:text-white text-xs"
                >
                    Sign in
                </button>
            </a>
            <router-link to="/pricing">
                <button
                    class="px-3 py-2 border-blue-300 text-blue-500 text-sm tracking-wider mx-1 rounded font-semibold hover:bg-blue-500 focus:outline-none hover:text-white text-xs"
                >
                    Pricing
                </button>
            </router-link>
        </div>
        <div class="mt-4 mr-2 md:hidden">
            <button
                type="button"
                @click="handleOpenMenu"
                class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
            >
                <svg
                    class="h-6 w-6"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>
            </button>
        </div>
        <transition
            name="fade"
            v-enter-active="'transition ease-out duration-200'"
            v-enter="'opacity-0 translate-y-1'"
            v-enter-to="'opacity-100 translate-y-0'"
            v-leave-active="'transition ease-in duration-150'"
            v-leave="'opacity-100 translate-y-0'"
            v-leave-to="'opacity-0 translate-y-1'"
        >
            <div
                class="bg-white absolute top-0 w-full shadow-lg pb-1 block md:hidden transition ease-out duration-200"
                v-if="show_mobile_menu"
            >
                <div class="flex flex-row  justify-between mb-2">
                    <img
                        :src="logo"
                        width="90px"
                        class="mx-4 mt-2"
                        alt="HishabGuru"
                    />
                    <button
                        type="button"
                        @click="handleOpenMenu"
                        class="bg-white right rounded-md py-2 px-4 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                    >
                        <svg
                            class="h-5 w-5"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </div>
                <router-link to="/pricing">
                    <a class="p-2 flex items-start  hover:bg-gray-50 ">
                        <div class="ml-4">
                            <p class="text-base font-medium border-blue-300 text-blue-500 px-2">
                                Pricing
                            </p>
                        </div>
                    </a>
                </router-link>

                <!--                <router-link to="/blog">-->
                <!--                    <a class="p-2 flex items-start  hover:bg-gray-50">-->
                <!--                        <div class="ml-4">-->
                <!--                            <p class="text-base font-medium border-blue-300 text-blue-500 px-2">-->
                <!--                                Blog-->
                <!--                            </p>-->
                <!--                        </div>-->
                <!--                    </a>-->
                <!--                </router-link>-->
                <a
                    href="https://app.hishabguru.com/login"
                    class="p-2 flex items-start hover:bg-gray-50 mb-2"
                >
                    <div class="ml-4">
                        <p class="text-base font-medium border-blue-300 text-blue-500 px-2">
                            Sign In
                        </p>
                    </div>
                </a>
                <a
                    href="https://app.hishabguru.com/register"
                    class="p-2 flex items-start hover:bg-gray-50 border-t"
                >
                    <div class="ml-4 mt-1 flex flex-row justify-center w-full">
                        <p
                            class="text-base font-medium border-blue-300 bg-blue-500 text-white px-6 py-1 rounded-md"
                        >
                            Sign Up
                        </p>
                    </div>
                </a>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    props: {
        logo: String
    },
    data() {
        return {
            show_mobile_menu: false
        };
    },
    methods: {
        handleOpenMenu() {
            this.show_mobile_menu = !this.show_mobile_menu;
        }
    }
};
</script>
