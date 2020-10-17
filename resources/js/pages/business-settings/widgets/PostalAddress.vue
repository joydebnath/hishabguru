<template>
    <div class="grid grid-cols-5 mb-4">
        <div class="col-span-3">
            <div class="field">
                <b-switch size="is-small" type="is-info" v-model="same_as_physical_address" true-value="Yes"
                          false-value="No">
                    <strong class="tracking-wide text-orange-500">Same as Headquarter address</strong>
                </b-switch>
            </div>
            <label class="label text-gray-700">Postal Address</label>
            <b-field label="Address line 1" custom-class="text-sm">
                <b-input custom-class="text-sm" v-model="computed_items.address_line_1" required></b-input>
            </b-field>
            <b-field label="Address line 2" custom-class="text-sm">
                <b-input custom-class="text-sm" v-model="computed_items.address_line_2"></b-input>
            </b-field>
            <b-field grouped>
                <b-field label="City" custom-class="text-sm">
                    <b-input custom-class="text-sm" v-model="computed_items.city" required></b-input>
                </b-field>
                <b-field label="Postal Code" custom-class="text-sm">
                    <b-input custom-class="text-sm" v-model="computed_items.postcode" required></b-input>
                </b-field>
            </b-field>
            <b-field grouped>
                <b-field label="State/Division" custom-class="text-sm">
                    <b-input custom-class="text-sm" v-model="computed_items.state" required></b-input>
                </b-field>
                <b-field label="Country" custom-class="text-sm">
                    <b-input custom-class="text-sm" v-model="computed_items.country" required></b-input>
                </b-field>
            </b-field>
        </div>
    </div>
</template>

<script>
export default {
    name: "PostalAddress",
    props: {
        address: Object | Array
    },
    data() {
        return {
            items: {},
            same_as_physical_address: false
        }
    },
    methods: {
        collect() {
            return this.computed_items
        }
    },
    computed: {
        computed_items() {
            if (this.$props.address) {
                this.items = {...this.$props.address}
            }
            return this.items
        }
    }
}
</script>

<style scoped>

</style>
