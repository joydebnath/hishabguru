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
                        <p class="-mb-1 -mt-2" v-if="loading">
                            <b-skeleton active/>
                            <b-skeleton height="50px"/>
                        </p>
                        <section class="grid grid-cols-2 px-4" v-else>
                            <div class="field mb-0" v-for="status in $props.options">
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
</template>

<script>
export default {
    name: "RadioBox",
    props: {
        show: false,
        options: Object | Array,
        title: {
            type: String,
            default: ''
        },
        handler: Function,
        loading: Boolean
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
