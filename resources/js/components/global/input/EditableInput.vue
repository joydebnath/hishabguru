<template>
    <div>
        <template v-if="$props.editable">
            <input
                v-model="input_value"
                class="border-b py-0 outline-none w-12 text-center"
                :placeholder="$props.placeholder"
                @input="$emit('on-input', input_value)"
            />
        </template>
        <template v-else>
            <span class="px-3 py-0 outline-none w-16 text-center">{{ $props.value }}</span>
        </template>
    </div>
</template>

<script>
export default {
    name: "EditableInput",
    props: {
        placeholder: String,
        editable: Boolean,
        value: Number
    },
    data() {
        return {
            input_value: null
        }
    }
}
</script>

<style scoped>

</style>
