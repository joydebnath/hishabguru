<template>
    <div :class="[!$props.editable ? 'mb-px' : null]">
        <template v-if="$props.editable">
            <input
                v-model="input_value"
                class="border-b py-0 outline-none w-12 text-center"
                :placeholder="$props.placeholder"
                @input="handleInput"
            />
        </template>
        <template v-else>
            <span class="px-3 py-0 outline-none w-16 text-center text-sm">{{ $props.value }}</span>
        </template>
    </div>
</template>

<script>
export default {
    name: "EditableInput",
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
            if (this.input_value !== '' && !Number(this.input_value)) {
                this.input_value = this.$props.value;
                return;
            }
            const number = this.input_value < 0 ? Math.abs(this.input_value) : this.input_value
            this.$emit('on-input', number, this.$props.id)
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
