<template>
    <section>
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
                        <div class="content border-b px-4 pt-4 pb-0 text-sm">
                            <section class="grid grid-cols-2 px-4">
                                <div class="field" v-for="status in $props.statuses">
                                    <b-radio v-model="radio" :native-value="status.value">
                                        {{ status.name }}
                                    </b-radio>
                                </div>
                            </section>
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
    </section>
</template>

<script>
export default {
    name: "UpdateStatusBox",
    props: {
        show: false,
        statuses: Object | Array,
        title: {
            type: String,
            default: 'Update Status'
        },
        handler: Function
    },
    data() {
        return {
            radio: null
        }
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
