<template>
    <footer class="flex justify-content-between bg-gray-100 mt-4 py-3 -mx-5 px-5 border-t">
        <router-link :to="$props.cancel_route">
            <button class="button py-0 px-3">
                Cancel
            </button>
        </router-link>
        <div>
            <button class="button " @click="$emit('on-save-as-draft')" v-if="!$props.hide_draft">Draft</button>
            <button class="button py-1 is-primary mx-1" @click="$emit('on-save')">
                Save
            </button>
            <b-dropdown aria-role="list" append-to-body v-if="$props.other_action">
                <button class="button px-2 is-primary" slot="trigger" slot-scope="{ active }">
                    <b-icon :icon="active ? 'menu-up' : 'menu-down'"/>
                </button>
                <b-dropdown-item aria-role="listitem" @click="$emit('on-save-for-approval')" v-if="!$props.hide_approval">
                    Save for Approval
                </b-dropdown-item>
            </b-dropdown>
        </div>
    </footer>
</template>

<script>
export default {
    name: "FooterActions",
    props: {
        cancel_route: {
            type: String,
            default: '/@/dashboard'
        },
        other_action: {
            type: Boolean,
            default: false
        },
        hide_draft: {
            type: Boolean,
            default: false
        },
        hide_approval: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style scoped>

</style>
