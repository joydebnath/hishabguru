<template>
    <div class="grid grid-cols-5">
        <div class="col-span-3">
            <label class="label text-gray-700">Headquarter Address</label>
            <b-field label="Address line 1" custom-class="text-sm">
                <b-input custom-class="text-sm"></b-input>
            </b-field>
            <b-field label="Address line 2" custom-class="text-sm">
                <b-input custom-class="text-sm"></b-input>
            </b-field>
            <b-field grouped>
                <b-field label="City" custom-class="text-sm">
                    <b-input custom-class="text-sm"></b-input>
                </b-field>
                <b-field label="Postal Code" custom-class="text-sm">
                    <b-input custom-class="text-sm"></b-input>
                </b-field>
            </b-field>
            <b-field grouped>
                <b-field label="State/Division" custom-class="text-sm">
                    <b-input custom-class="text-sm"></b-input>
                </b-field>
                <b-field label="Country" custom-class="text-sm">
                    <b-input custom-class="text-sm"></b-input>
                </b-field>
            </b-field>
        </div>
    </div>
</template>

<script>
export default {
    name: "PhysicalAddress"
}
</script>

<style scoped>

</style>
