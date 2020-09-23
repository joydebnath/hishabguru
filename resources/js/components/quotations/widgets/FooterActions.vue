<template>
    <footer class="modal-card-foot flex justify-content-end ">
        <template v-if="$props.action_type == 'add'">
            <button class="button" @click="$emit('on-save-as-draft')">Draft</button>
            <button class="button is-primary" @click="$emit('on-save')">
                Save
            </button>
            <b-dropdown aria-role="list" append-to-body class="quotation-save" v-if="is_not_admin">
                <button class="button px-2 is-primary" slot="trigger" slot-scope="{ active }">
                    <b-icon :icon="active ? 'menu-up' : 'menu-down'"/>
                </button>
                <b-dropdown-item aria-role="listitem" @click="$emit('on-save-for-approval')">
                    Save for Approval
                </b-dropdown-item>
            </b-dropdown>
        </template>
        <template v-else>
            <button class="button is-primary" @click="$emit('on-save')">
                Update
            </button>
        </template>
    </footer>
</template>

<script>
export default {
    name: "FooterActions",
    props: {
        action_type: String
    },
    data() {
        return {
            is_not_admin: false
        }
    }
}
</script>

<style>
.quotation-save .dropdown-menu .dropdown-content {
    padding-top: 0;
    padding-bottom: 0;
}
</style>
