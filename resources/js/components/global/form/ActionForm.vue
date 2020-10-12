<template>
    <section>
        <div class="hidden sm:block" v-if="$props.show_top_divider">
            <div class="pb-8">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>
        <div class="md:grid md:grid-cols-3 md:gap-6 mt-10 sm:mt-0">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ $props.action_name }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ $props.action_description }}
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form>
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <slot></slot>
                            </div>
                        </div>
                        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <b-button type="is-info" class="text-sm rounded tracking-wider font-medium" @click="$emit('on-save')">
                                Save
                            </b-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "ActionForm",
    props: {
        action_name: String,
        action_description: String,
        show_top_divider: {
            type: Boolean,
            default: true
        }
    }
}
</script>

<style scoped>

</style>
