<template>
    <b-modal
        v-model="$props.show"
        has-modal-card
        trap-focus
        :destroy-on-hide="true"
        aria-role="dialog"
        aria-modal
        :width="500"
        :on-cancel="handleCancel"
        :can-cancel="['x']"
    >
        <div class="card py-3" style="width: 550px">
            <div class="flex flex-col justify-content-between">
                <h3 class="text-lg font-medium text-center mb-3 text-gray-700">{{ $props.title }}</h3>
            </div>
            <article class="media border-t">
                <div class="media-content">
                    <div class="content border-b p-4 text-sm">
                        <input type="hidden" id="testing-code" :value="$props.url"/>
                        <b-field custom-class="text-sm">
                            <b-input placeholder="Copy" type="text" :value="$props.url" expanded/>
                            <p class="control">
                                <button
                                    class="button is-primary"
                                    v-text="btn_text"
                                    @click.stop.prevent="copyTestingCode"
                                ></button>
                            </p>
                        </b-field>
                    </div>
                    <nav class="level px-4">
                        <div class="level-left"></div>
                        <div class="level-right">
                            <div class="level-item">
                                <button class="button is-light text-sm text-uppercase tracing-wide"
                                        @click="handleCancel">
                                    cancel
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
    name: "CopyUrlBox",
    props: {
        show: false,
        title: {
            type: String,
            default: ''
        },
        url: String
    },
    data() {
        return {
            btn_text: 'Copy'
        }
    },
    methods: {
        copyTestingCode() {
            let testingCodeToCopy = document.querySelector('#testing-code')
            testingCodeToCopy.setAttribute('type', 'text')
            testingCodeToCopy.select()

            try {
                document.execCommand('copy');
                this.btn_text = 'Copied!';
            } catch (err) {
                this.btn_text = 'Try again';
            }
            testingCodeToCopy.setAttribute('type', 'hidden')
            window.getSelection().removeAllRanges()
        },
        handleCancel() {
            this.$emit('on-close')
            this.btn_text = 'Copy'
        }
    }
}
</script>

<style scoped>

</style>
