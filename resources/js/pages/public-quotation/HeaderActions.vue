<template>
    <div class="flex flex-row justify-content-between -mx-2">
        <div>
            <button class="button is-info tracking-wider uppercase font-medium is-small"
                    @click="handleAccept"
                    v-if="show_accept_action"
            >
                Accept
            </button>
            <button class="button is-danger tracking-wider uppercase font-medium is-outlined is-small"
                    @click="handleDecline"
                    v-if="show_decline_action"
            >
                Decline
            </button>
        </div>
        <button class="button is-light is-small" @click="handlePrint">
            <svg class="h-4" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M18 16H21C21.5523 16 22 15.5523 22 15V9C22 8.44772 21.5523 8 21 8H3C2.44772 8 2 8.44772 2 9V15C2 15.5523 2.44772 16 3 16H6"
                    stroke="#000" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round"></path>
                <path d="M6 12H18V20C18 20.5523 17.5523 21 17 21H7C6.44772 21 6 20.5523 6 20V12Z"
                      stroke="#000" stroke-width="1.5" stroke-linecap="round"
                      stroke-linejoin="round"></path>
                <path d="M6 4C6 3.44772 6.44772 3 7 3H17C17.5523 3 18 3.44772 18 4V8H6V4Z" stroke="#000"
                      stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span>Print</span>
        </button>
    </div>
</template>

<script>
export default {
    name: "HeaderActions",
    props: {
        quotation: Array | Object,
    },
    computed: {
        show_accept_action() {
            const STATUSES = ['open', 'accepted','declined']
            return _.indexOf(STATUSES, this.$props.quotation.status) !== -1
        },
        show_decline_action() {
            const STATUSES = ['open']
            return _.indexOf(STATUSES, this.$props.quotation.status) !== -1
        },
    },
    methods: {
        handleAccept() {

        },
        handleDecline() {

        },
        handlePrint() {

        }
    }
}
</script>

