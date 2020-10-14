<template>
    <ActionForm action_name="Contact Details" action_description="Keep your business contact details upto date">
        <PhysicalAddress/>
        <div class="grid grid-cols-5 border-b my-4"></div>
        <div class="grid grid-cols-5">
            <div class="col-span-3">
                <b-field label="Phone Number" custom-class="text-sm">
                    <b-input custom-class="text-sm"></b-input>
                </b-field>
                <b-field label="Email" custom-class="text-sm">
                    <b-input custom-class="text-sm"></b-input>
                </b-field>
                <b-field label="Website" custom-class="text-sm">
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
import PostalAddress from "./widgets/PostalAddress";
import PhysicalAddress from "./widgets/PhysicalAddress";

export default {
    name: "BusinessDetails",
    components: {PhysicalAddress, PostalAddress, ActionForm}
}
</script>

<style scoped>

</style>
