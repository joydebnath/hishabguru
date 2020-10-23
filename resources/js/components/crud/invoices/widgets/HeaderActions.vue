<template>
    <div class="flex flex-row justify-content-end mb-2" v-show="false">
        <b-tooltip label="Add Payment Record" position="is-right" type="is-dark">
            <b-button size="is-small" class="mx-2 font-semibold rounded-md" @click="$emit('on-add-payment')">
                + Payment
            </b-button>
        </b-tooltip>
        <b-button size="is-small" class="mx-2 font-semibold rounded-md" @click="handlePrint">Print</b-button>
        <!--    <b-tooltip label="Upload File" position="is-right" type="is-dark">-->
        <!--      <b-button-->
        <!--          size="is-small"-->
        <!--          class="mx-2 font-semibold rounded-md"-->
        <!--          v-if="$props.show_upload"-->
        <!--          @click="handleShowUploader"-->
        <!--      >-->
        <!--        <b-icon pack="fas" icon="upload"/>-->
        <!--      </b-button>-->
        <!--    </b-tooltip>-->
        <!--    <b-button size="is-small" class="mx-2 font-semibold rounded-md" v-if="$props.show_print">Print</b-button>-->
        <b-dropdown aria-role="list" append-to-body size="is-small" v-if="$props.show_option">
            <button class="button px-2 is-small rounded-md" slot="trigger" slot-scope="{ active }">
                <span class="font-semibold">Options</span>
                <b-icon :icon="active ? 'menu-up' : 'menu-down'"/>
            </button>
            <b-dropdown-item class="text-red-700" @click="handleDeleteOpen">
                Delete
            </b-dropdown-item>
        </b-dropdown>
        <DownloadingBox :show="downloading"/>
        <DeleteBox
            :show="show_delete"
            :handler="onConfirmDelete"
            @on-close="handleDeleteClose"
        />
    </div>
</template>

<script>
import DeleteBox from "@/components/global/popups/DeleteBox";
import DownloadingBox from "@/components/global/popups/DownloadingBox";

import headerActionsMixin from '../mixins/header-actions'

export default {
    name: "HeaderActions",
    mixins: [headerActionsMixin],
    components: {DeleteBox, DownloadingBox},
    props: {
        invoice: Object | Array,
        show_option: {
            type: Boolean,
            default: true
        },
        show_print: {
            type: Boolean,
            default: true
        },
        show_upload: {
            type: Boolean,
            default: true
        },
    },
    data() {
        return {
            show_uploader: false,
            show_delete: false,
            downloading: false,
        }
    },
    methods: {
        handleShowUploader() {
            this.show_uploader = true
        },
        closeShowUploader() {
            this.show_uploader = false
        },
        handleDeleteOpen() {
            this.show_delete = true
        },
        handleDeleteClose() {
            this.show_delete = false
        },
    }
}
</script>
