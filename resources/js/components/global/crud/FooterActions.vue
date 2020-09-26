<template>
    <footer class="flex justify-content-between bg-gray-100 mt-4 py-3 -mx-5 px-5 border-t">
        <router-link :to="$props.cancel_route">
            <button class="button py-0 px-3">
                Cancel
            </button>
        </router-link>
        <div>
            <button class="button " @click="$emit('on-save-as-draft')">Draft</button>
            <button class="button py-1 is-primary mx-1" @click="$emit('on-save')">
                Save
            </button>
            <b-dropdown aria-role="list" append-to-body v-if="$props.other_action">
                <button class="button px-2 is-primary" slot="trigger" slot-scope="{ active }">
                    <b-icon :icon="active ? 'menu-up' : 'menu-down'"/>
                </button>
                <b-dropdown-item aria-role="listitem" @click="$emit('on-save-for-approval')">
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
        other_action: {
            type: Boolean,
            default: false
        },
        cancel_route: {
            type: String,
            default: '/@/dashboard'
        }
    }
}
</script>

<style scoped>

</style>
