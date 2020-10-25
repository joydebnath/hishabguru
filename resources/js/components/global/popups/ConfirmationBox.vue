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
        <div class="card py-3" style="width: 350px">
            <div class="flex flex-col justify-content-between">
                <h3 class="text-lg font-medium text-center mb-3 text-gray-700">{{ $props.title }}</h3>
            </div>
            <article class="media border-t">
                <div class="media-content">
                    <div class="content border-b p-4 text-sm">
                        <p class="mb-1">{{ $props.message }}</p>
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
                                <button class="button is-info text-sm text-uppercase tracing-wide"
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
    name: "ConfirmationBox",
    props: {
        show: false,
        title: {
            type: String,
            default: ''
        },
        message: {
            type: String,
            default: ''
        },
        handler: Function
    },
    methods: {
        handleConfirm() {
            this.$props.handler(this.radio);
        }
    }
}
</script>

<style scoped>

</style>
