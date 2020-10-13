<template>
    <ActionForm action_name="Business Details" action_description="Keep your business details upto date">
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
