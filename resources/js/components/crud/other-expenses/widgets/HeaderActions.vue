<template>
  <div class="flex flex-row justify-content-end mb-2" v-show="false">
    <b-tooltip label="Add Payment Record" position="is-right" type="is-dark">
      <b-button size="is-small" class="mx-2 font-semibold rounded-md" @click="$emit('on-add-payment')">+ Payment</b-button>
    </b-tooltip>
    <b-dropdown aria-role="list" append-to-body size="is-small" v-if="$props.show_option">
      <button class="button px-2 is-small rounded-md" slot="trigger" slot-scope="{ active }">
        <span class="font-semibold">Options</span>
        <b-icon :icon="active ? 'menu-up' : 'menu-down'"/>
      </button>
      <b-dropdown-item class="text-red-700" @click="$emit('on-delete')">
        Delete
      </b-dropdown-item>
    </b-dropdown>
  </div>
</template>

<script>
export default {
  name: "HeaderActions",
  props: {
    show_option: {
      type: Boolean,
      default: true
    },
  }
}
</script>
