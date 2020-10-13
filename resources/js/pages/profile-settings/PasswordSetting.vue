<template>
    <ActionForm action_name="Password Settings"
                action_description="Keep your password secure and do not share with others">
        <div class="grid grid-cols-5">
            <div class="col-span-3">
                <b-field label="Current Password" custom-class="text-sm">
                    <b-input custom-class="text-sm" type="password" password-reveal/>
                </b-field>
                <b-field label="New Password" custom-class="text-sm">
                    <b-input custom-class="text-sm" type="password" password-reveal/>
                </b-field>
                <b-field label="Confirm New Password" custom-class="text-sm">
                    <b-input custom-class="text-sm" type="password" password-reveal></b-input>
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
    name: "PasswordSetting",
    components: {ActionForm}
}
</script>

<style scoped>

</style>
