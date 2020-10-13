<template>
    <ActionForm action_name="Contact Details" action_description="Keep your contact details updated">
        <div class="grid grid-cols-5 mb-4">
            <div class="col-span-3">
                <label class="label text-gray-700">Postal address</label>
                <b-field label="Address line 1" custom-class="text-sm">
                    <b-input custom-class="text-sm"></b-input>
                </b-field>
                <b-field label="Address line 2" custom-class="text-sm">
                    <b-input custom-class="text-sm"></b-input>
                </b-field>
                <b-field grouped>
                    <b-field label="City/Town" custom-class="text-sm">
                        <b-input custom-class="text-sm"></b-input>
                    </b-field>
                    <b-field label="Postal Code" custom-class="text-sm">
                        <b-input custom-class="text-sm"></b-input>
                    </b-field>
                </b-field>
                <b-field grouped>
                    <b-field label="Division" custom-class="text-sm">
                        <b-input custom-class="text-sm"></b-input>
                    </b-field>
                    <b-field label="Country" custom-class="text-sm">
                        <b-input custom-class="text-sm"></b-input>
                    </b-field>
                </b-field>
            </div>
        </div>
        <div class="grid grid-cols-5 border-b mb-4"></div>
        <div class="grid grid-cols-5">
            <div class="col-span-3">
                <b-field label="Phone Number" custom-class="text-sm">
                    <b-input custom-class="text-sm"></b-input>
                </b-field>
                <b-field label="Email" custom-class="text-sm">
                    <b-input custom-class="text-sm"></b-input>
                </b-field>
            </div>
        </div>
        <template #footer>
            <b-button type="is-info" class="text-sm rounded tracking-wider font-medium" @click="$emit('on-save')">
                Save
            </b-button>
        </template>
    </ActionForm>
</template>

<script>
import ActionForm from "@/components/global/form/ActionForm";
export default {
name: "ContactSetting",
    components: {ActionForm}
}
</script>

<style scoped>

</style>
