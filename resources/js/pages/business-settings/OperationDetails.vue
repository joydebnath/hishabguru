<template>
    <ActionForm
        action_name="Operation Details"
        action_description="Keep your business operation details updated to generate correct documents"
    >
        <template>
            <div class="grid grid-cols-5">
                <div class="col-span-4">
                    <b-field grouped>
                        <b-field label="Business Country" custom-class="text-sm">
                            <b-input custom-class="text-sm"></b-input>
                        </b-field>
                        <b-field label="Currency" custom-class="text-sm">
                            <b-input custom-class="text-sm"></b-input>
                        </b-field>
                    </b-field>
                </div>
            </div>
        </template>
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
    name: "BusinessDetails",
    components: {ActionForm}
}
</script>

<style scoped>

</style>
