<template>
    <div class="absolute mt-1 w-full rounded-md bg-white shadow-lg z-10 " style="top: 72px">
        <ul tabindex="-1" role="listbox" aria-labelledby="listbox-label"
            style="max-height: 270px;overflow: auto;"
            class="max-h-56 rounded-md py-1 text-base leading-6 shadow-xs overflow-auto focus:outline-none sm:text-sm sm:leading-5">
            <li role="option"
                v-if="loading"
                class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9 hover:text-gray-800 hover:bg-gray-100">
                <div class="flex mr-3 space-x-3">
                    <b-skeleton :animated="true"></b-skeleton>
                </div>
            </li>
            <template v-else>
                <li role="option"
                    class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9 hover:text-gray-800 hover:bg-gray-100 border-b cursor-pointer">
                    <div class="flex flex-col space-x-3 py-2 ">
                        <p class="mb-1">+ Add Client</p>
                        <p class="ml-4 text-gray-700">Joy Debn</p>
                    </div>

                </li>
                <small class="px-4 mt-2 flex font-semibold tracking-wider uppercase leading-5">Clients</small>
                <li role="option"
                    v-for="i in 5" :key="i"
                    class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9 hover:text-gray-800 hover:bg-gray-100 cursor-pointer">
                    <div class="flex items-center space-x-3">
                        <ClientTile />
                    </div>
                </li>
            </template>
        </ul>
    </div>
</template>

<script>
import ClientTile from "./ClientTile";

export default {
    name: "ClientDropdown",
    components:{
        ClientTile
    },
    data(){
        return{
            loading: false
        }
    }
}
</script>

<style scoped>

</style>
