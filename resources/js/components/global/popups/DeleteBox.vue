<template>
    <b-modal
        v-model="$props.show"
        has-modal-card
        trap-focus
        :destroy-on-hide="false"
        aria-role="dialog"
        aria-modal
        :width="500"
        :can-cancel="['x']"
    >
        <div class="card py-3">
            <div class="flex flex-col justify-content-between">
                <h3 class="text-xl font-medium text-center mb-3 text-gray-600">{{ $props.title }}</h3>
                <div class="flex flex-row justify-content-center pb-3">
                    <svg viewBox="0 0 512 512" class="h-16 w-16" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="m512 256c0 141.386719-114.613281 256-256 256s-256-114.613281-256-256 114.613281-256 256-256 256 114.613281 256 256zm0 0"
                            fill="#ff641a"/>
                        <path
                            d="m377.863281 149.886719-18.421875 18.421875-75.292968-75.296875-13.1875 43.113281-43.0625-43.0625-52.230469 99.601562 106.390625 109.902344-110.429688 110.429688 98.601563 98.605468c125.886719-6.902343 227.546875-104.742187 240.394531-228.953124zm0 0"
                            fill="#f03800"/>
                        <path
                            d="m227.875 93-56.277344 64.941406 14.117188 12.339844 60.910156 8.066406 16.433594-44.511718zm0 0"
                            fill="#fdbf00"/>
                        <path
                            d="m368.5 234.25-20.625 9.375 16.875 9.375-11.25 56.25-20.8125 9.9375 17.0625 8.8125-9.375 46.875-18 18.75h-129.5625l-21.1875-18.75-9.375-46.875 17.0625-8.8125-20.8125-9.9375-11.25-56.25 16.875-9.75-20.625-9-9.375-46.875 18-18.75h200.8125l24.9375 18.75zm0 0"
                            fill="#f2f2fc"/>
                        <path
                            d="m368.5 234.25-20.625 9.375 16.875 9.375-11.25 56.25-20.8125 9.9375 17.0625 8.8125-9.375 46.875-18 18.75h-66.375v-225h96.9375l24.9375 18.75zm0 0"
                            fill="#d8d8fc"/>
                        <path
                            d="m284.125 93-56.277344 64.941406 14.117188 12.339844h84.320312l14.117188-12.339844zm0 0"
                            fill="#ffda2d"/>
                        <path d="m368.5 234.25-3.75 18.75h-217.5l-3.75-18.75zm0 0" fill="#d8d8fc"/>
                        <path d="m353.5 309.25-3.75 18.75h-187.5l-3.75-18.75zm0 0" fill="#d8d8fc"/>
                        <g fill="#a3a3d1">
                            <path d="m256 309.25h97.5l-3.75 18.75h-93.75zm0 0"/>
                            <path d="m368.5 234.25-3.75 18.75h-108.75v-18.75zm0 0"/>
                            <path d="m315.316406 168.625-24.996094 225h18.867188l25-225zm0 0"/>
                        </g>
                        <path d="m177.820312 168.625 24.992188 225h18.867188l-24.992188-225zm0 0" fill="#d8d8fc"/>
                        <path d="m246.625 168.625h18.75v225h-18.75zm0 0" fill="#d8d8fc"/>
                        <path d="m256 168.625h9.375v225h-9.375zm0 0" fill="#a3a3d1"/>
                        <path d="m171.625 374.875h168.75v38.125h-168.75zm0 0" fill="#61729b"/>
                        <path d="m256 374.875h84.375v38.125h-84.375zm0 0" fill="#47568c"/>
                        <path d="m134.125 149.875h243.75v37.5h-243.75zm0 0" fill="#61729b"/>
                        <path d="m256 149.875h121.875v37.5h-121.875zm0 0" fill="#47568c"/>
                    </svg>
                </div>
            </div>
            <article class="media">
                <div class="media-content">
                    <div class="content border-b px-4 pb-2 text-sm">
                        <p class="mb-1">{{ $props.message }}</p>
                        <p class="text-red-600">Are you sure?</p>
                    </div>
                    <nav class="level px-4">
                        <div class="level-left">
                            <div class="level-item">
                                <button class="button is-light text-sm text-uppercase tracing-wide"
                                        @click="$emit('on-close')">
                                    cancel
                                </button>
                            </div>
                        </div>
                        <div class="level-right">
                            <div class="level-item">
                                <button class="button is-danger text-sm text-uppercase tracing-wide"
                                        @click="handleConfirm">
                                    confirm
                                </button>
                            </div>
                        </div>
                    </nav>
                </div>
            </article>
        </div>
    </b-modal>
</template>

<script>
export default {
    name: "DeleteBox",
    props: {
        show: false,
        message: {
            type: String,
            default: 'This will delete the content for good'
        },
        title: {
            type: String,
            default: 'Delete the record?'
        },
        handler: Function
    },
    methods:{
        handleConfirm(){
            this.$props.handler();
        }
    }
}
</script>

<style scoped>

</style>
