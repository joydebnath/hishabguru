<template>
    <ActionForm action_name="Personal Details" action_description="Keep your personal details updated">
        <div class="grid grid-cols-5">
            <div class="col-span-3">
                <b-field label="Name" custom-class="text-sm">
                    <b-input custom-class="text-sm"></b-input>
                </b-field>
                <b-field label="Job Title" custom-class="text-sm">
                    <b-input custom-class="text-sm"></b-input>
                </b-field>
                <b-field label="Email Address" custom-class="text-sm">
                    <b-input type="email" custom-class="text-sm"></b-input>
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
name: "PersonalDetails",
    components: {ActionForm}
}
</script>

<style scoped>

</style>
