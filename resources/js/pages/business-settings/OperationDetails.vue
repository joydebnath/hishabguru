<template>
    <ActionForm
        action_name="Operation Details"
        action_description="Keep your business operation details updated to generate correct documents"
    >
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
