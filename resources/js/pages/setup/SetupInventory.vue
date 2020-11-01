<template>
    <div class="container mt-10">
        <div class="row justify-content-center max-w-2xl m-auto">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <div class="flex flex-row justify-content-between">
                        <section>
                            <h3 class="text-xl leading-6 font-medium text-gray-900">
                                Final step...
                            </h3>
                            <p class="mt-1 max-w-2xl text-base leading-5 text-gray-500">
                                Set <span class="text-gray-600">{{ $props.tenant.name }}'s</span> Inventory Location
                            </p>
                        </section>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-5 ">
                    <form class="d-block mb-3" method="POST" action="/init" id="form">
                        <input hidden name="address_type" type="text" value="headquarter">
                        <input hidden name="tenant_id" type="number" :value="$props.tenant.id">
                        <div class="field">
                            <label class="label">Business Address Type</label>
                            <div class="control">
                                <input class="input" name="name" type="text" value="" placeholder="e.g. Online Store">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">
                                Tax Identification Number
                                <small class="text-xs">Optional</small>
                            </label>
                            <div class="control">
                                <input class="input" name="tfn" type="text" value="">
                            </div>
                        </div>
                        <p class="font-semibold mt-4 my-3 ">
                        <span class="mr-2">
                            Address
                            <span class="tag">
                                Headquarter
                            </span>
                        </span>
                        </p>
                        <div class="field">
                            <div class="control mb-3">
                                <input class="input mb-3" type="text" name="address_line_1"
                                       placeholder="Address line 1">
                                <input class="input" type="text" name="address_line_2" placeholder="Address line 2">
                            </div>
                            <div class="field-body mb-3">
                                <div class="field is-grouped">
                                    <div class="control is-clearfix">
                                        <input type="text" placeholder="City" name="city" class="input">
                                    </div>
                                    <div class="control is-clearfix">
                                        <input type="text" placeholder="Post Code" name="postcode" class="input">
                                    </div>
                                </div>
                            </div>
                            <div class="field-body ">
                                <div class="field is-grouped">
                                    <div class="control is-clearfix">
                                        <input type="text" placeholder="State/Division" name="state" class="input">
                                    </div>
                                    <div class="control is-clearfix">
                                        <input type="text" name="country" value="Bangladesh" placeholder="Country"
                                               class="input">
                                    </div>
                                </div>
                            </div>
                            <p class="font-semibold mt-4 my-3 ">
                                <span class="mr-2">
                                    Operation Details
                                </span>
                            </p>
                            <div class="field">
                                <div class="field is-grouped">
                                    <div class="control">
                                        <input type="text" placeholder="Business Country" value="Bangladesh"
                                               name="operation_country" class="input">
                                    </div>
                                    <div class="control">
                                        <input type="text" name="operation_currency" value="BDT"
                                               placeholder="Operation Currency" class="input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="flex flex-row-reverse">
                        <button
                            class="text-white bg-gray-800 tracking-wider uppercase text-sm px-4 py-2 rounded-md"
                            @click="handleSubmit"
                        >
                            Start
                        </button>
                    </div>
                </div>
                <section class="mx-4 my-2">
                    <div class="notification is-danger mb-2 py-2 text-sm text-capitalize" v-for="i in []">
                        {{ i }}
                    </div>
                </section>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    name: "SetupInventory",
    props: {
        tenant: Object | Array
    },
    methods: {
        handleSubmit() {
            const form = document.getElementById('form');
            form.submit()
        }
    }
}
</script>

<style scoped>

</style>
