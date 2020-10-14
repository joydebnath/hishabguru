<template>
    <ActionForm action_name="Business Details" action_description="Keep your business details upto date">
        <template>
            <div class="grid grid-cols-5">
                <div class="col-span-3">
                    <b-field label="Name" custom-class="text-sm">
                        <b-input custom-class="text-sm" ></b-input>
                    </b-field>
                    <b-field label="What is your line of business?" custom-class="text-sm">
                        <b-input custom-class="text-sm" placeholder="e.g. Online Retail, Restaurant"></b-input>
                    </b-field>
                    <b-field label="Tax File Number" custom-class="text-sm">
                        <b-input custom-class="text-sm" ></b-input>
                    </b-field>
                    <b-field label="Description" custom-class="text-sm">
                        <b-input type="textarea" :rows="3" maxlength="250" custom-class="text-sm"></b-input>
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
    components: {ActionForm},
    props:{
        fields: Object | Array
    },
    data() {
        return {
            items: {}
        }
    },
    computed: {
        computed_items() {
            if (this.$props.fields) {
                this.items = {...this.$props.fields}
            }
            return this.items
        }
    }
}
</script>

<style scoped>

</style>
