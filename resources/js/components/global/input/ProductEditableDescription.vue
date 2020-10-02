<template>
    <div :class="[!$props.editable ? 'mb-px' : null]">
        <template v-if="$props.editable">
            <input
                v-model="input_value"
                class="border-b py-0 outline-none text-xs w-full text-center"
                :placeholder="$props.placeholder"
                @input="handleInput"
            />
        </template>
        <template v-else>
            <span class="px-3 py-0 outline-none w-full text-xs text-center">{{ $props.value }}</span>
        </template>
    </div>
</template>

<script>
export default {
    name: "EditableDescription",
    props: {
        placeholder: String,
        editable: Boolean,
        value: Number | null,
        id: Number | null
    },
    data() {
        return {
            input_value: this.$props.value
        }
    },
    methods: {
        handleInput() {
            this.$emit('on-input', this.input_value, this.$props.id)
        }
    },
    watch: {
        value(val) {
            this.input_value = val
        }
    }
}
</script>

<style scoped>

</style>
