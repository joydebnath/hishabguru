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
                <small class="px-4 mt-2 flex font-semibold tracking-wider uppercase leading-5">Suppliers</small>
                <li role="option"
                    v-for="i in 5" :key="i"
                    class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9 hover:text-gray-800 hover:bg-gray-100 cursor-pointer">
                    <div class="flex items-center space-x-3">
                        <SupplierTile />
                    </div>
                </li>
            </template>
        </ul>
    </div>
</template>

<script>
import SupplierTile from "./SupplierTile";

export default {
    name: "ClientDropdown",
    components:{
        SupplierTile
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
