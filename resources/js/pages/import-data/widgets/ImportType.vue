<template>
    <section class="pt-4 step-box">
        <div class="content has-text-centered mx-12">
            <p class="tracking-wider text-base leading-6 font-medium text-gray-900">
                Select import record type
            </p>
            <p class="p-6 bg-gray-100">
                Select the <strong>record</strong> type you want to upload in <span
                class="text-blue-500 font-medium tracking-wide">HishabGuru</span>
            </p>
            <p class="mt-6 flex flex-row justify-content-center">
                <b-dropdown v-model="type" @change="handleChange" aria-role="list">
                    <b-button
                        class="flex text-sm flex-row align-items-center"
                        slot="trigger"
                        type="is-dark"
                        :outlined="!type"
                    >
                        <span class="mt-1 text-capitalize">{{ type ? type : 'Select import record type' }}</span>
                        <b-icon pack="fas" icon="chevron-down fa-sm"/>
                    </b-button>
                    <b-dropdown-item v-for="type in types" :key="type" :value="type" aria-role="listitem">
                        <div class="media">
                            <div class="media-content">
                                <span class="text-capitalize">{{ type }}</span>
                            </div>
                        </div>
                    </b-dropdown-item>
                </b-dropdown>
            </p>
        </div>
    </section>
</template>

<script>
export default {
    name: "ImportType",
    data() {
        return {
            type: '',
            types: [
                'products', 'clients', 'suppliers'
            ]
        }
    },
    methods: {
        handleChange(type) {
            this.$emit('on-select', type)
        }
    }
}
</script>

<style scoped>

</style>
