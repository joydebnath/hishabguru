<template>
    <div class="flex flex-row-reverse mb-1" v-show="false">
        <b-dropdown aria-role="list" append-to-body size="is-small" v-if="true">
            <button class="button px-2 is-small rounded-md" slot="trigger" slot-scope="{ active }">
                <span class="font-semibold">Options</span>
                <b-icon :icon="active ? 'menu-up' : 'menu-down'"/>
            </button>
            <b-dropdown-item aria-role="listitem">
                Copy To
            </b-dropdown-item>
            <b-dropdown-item class="text-red-700" aria-role="listitem">
                Delete
            </b-dropdown-item>
        </b-dropdown>
        <b-button size="is-small" class="mx-2 font-semibold rounded-md">Print</b-button>
    </div>
</template>

<script>
export default {
    name: "HeaderActions"
}
</script>

<style scoped>

</style>
