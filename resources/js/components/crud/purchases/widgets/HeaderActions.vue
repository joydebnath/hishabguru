<template>
    <div class="flex flex-row-reverse mb-2" v-show="false">
        <b-dropdown aria-role="list" append-to-body size="is-small" v-if="$props.show_option">
            <button class="button px-2 is-small rounded-md" slot="trigger" slot-scope="{ active }">
                <span class="font-semibold">Options</span>
                <b-icon :icon="active ? 'menu-up' : 'menu-down'"/>
            </button>
            <b-dropdown-item aria-role="listitem">
                Copy To Bill
            </b-dropdown-item>
            <b-dropdown-item class="text-red-700" aria-role="listitem">
                Delete
            </b-dropdown-item>
        </b-dropdown>
        <b-button size="is-small" class="mx-2 font-semibold rounded-md" v-if="$props.show_print">Print</b-button>
        <b-button size="is-small" class="mx-2 font-semibold rounded-md" v-if="$props.show_upload" @click="handleShowUploader">Upload file</b-button>
        <b-button size="is-small" class="mx-2 font-semibold rounded-md" v-if="$props.show_sync">Sync inventory</b-button>
    </div>
</template>

<script>
export default {
    name: "HeaderActions",
    props:{
        show_option:{
            type: Boolean,
            default: true
        },
        show_print:{
            type: Boolean,
            default: true
        },
        show_sync:{
            type: Boolean,
            default: false
        },
        show_upload:{
            type: Boolean,
            default: true
        },
    },
    data(){
        return{
            show_uploader: false
        }
    },
    methods:{
        handleShowUploader(){
            this.show_uploader = true
        },
        closeShowUploader(){
            this.show_uploader = false
        }
    }
}
</script>

<style scoped>

</style>
