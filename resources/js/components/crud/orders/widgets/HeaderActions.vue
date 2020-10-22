<template>
    <div class="flex flex-row-reverse mb-1">
        <b-dropdown aria-role="list" append-to-body size="is-small" v-if="true">
            <button class="button px-2 is-small rounded-md" slot="trigger" slot-scope="{ active }">
                <span class="font-semibold">Options</span>
                <b-icon :icon="active ? 'menu-up' : 'menu-down'"/>
            </button>
            <!--      <b-dropdown-item aria-role="listitem">-->
            <!--        Copy To-->
            <!--      </b-dropdown-item>-->
            <b-dropdown-item aria-role="listitem" @click="handleStatusUpdate">
                Update Status
            </b-dropdown-item>
            <span class="dropdown-divider"></span>
            <b-dropdown-item class="text-red-700" aria-role="listitem" @click="handleDelete">
                Delete
            </b-dropdown-item>
        </b-dropdown>
        <b-button size="is-small" class="mx-2 font-semibold rounded-md" @click="handlePrint">Print</b-button>
        <DownloadingBox :show="downloading"/>
        <UpdateStatusBox
            title="Update Quotation Status"
            :statuses="statuses"
            :show="show_status_update"
            :handler="onConfirmStatusUpdate"
            @on-close="handleStatusUpdateClose"
        />
        <DeleteBox
            :show="show_delete"
            :handler="onConfirmDelete"
            @on-close="handleDeleteClose"
        />
    </div>
</template>

<script>
import DownloadingBox from "@/components/global/popups/DownloadingBox";
import UpdateStatusBox from "@/components/global/popups/UpdateStatusBox";
import DeleteBox from "@/components/global/popups/DeleteBox";
import {remove} from '@/repos/orders'

export default {
    name: "HeaderActions",
    components: {DeleteBox, UpdateStatusBox, DownloadingBox},
    props: {
        order: Object
    },
    data() {
        return {
            downloading: false,
            show_status_update: false,
            show_delete: false,
            statuses: [
                {name: 'Shipped', value: 'shipped'},
                {name: 'Fulfilled', value: 'fulfilled'},
                {name: 'Cancelled', value: 'cancelled'},
                {name: 'Returned', value: 'returned'},
            ]
        }
    },
    methods: {
        handleStatusUpdate() {
            this.show_status_update = true;
        },
        handleDelete() {
            this.show_delete = true;
        },
        handlePrint() {
            this.downloading = true
            axios
                .request({
                    url: '/print/order/' + this.$props.order.id,
                    method: 'GET',
                    responseType: 'blob',
                })
                .then(({data}) => {
                    this.downloading = false
                    const downloadUrl = window.URL.createObjectURL(new Blob([data]));
                    const link = document.createElement('a');
                    link.href = downloadUrl;
                    link.setAttribute('download', 'order' + this.$props.order.order_number + '.pdf');
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                })
                .catch(err => {
                    this.downloading = false
                    this.$buefy.snackbar.open({
                        duration: 5000,
                        message: 'Whoops! Download Failed. Please try again.',
                        type: 'is-danger',
                        position: 'is-top-right',
                        actionText: 'Ok',
                    })
                });
        },
        onConfirmDelete() {
            this.$emit('on-loading', true);
            remove(this.$props.order.id)
                .then(({data}) => {
                    this.$emit('on-loading', false);
                    this.$buefy.notification.open({
                        message: data.message,
                        type: 'is-success is-light',
                        duration: 5000
                    });
                    this.handleDeleteClose()
                    this.$router.push('/@/orders');
                })
                .catch(err => {
                    console.log(err)
                    if (err.response) {
                        this.$buefy.notification.open({
                            message: err.response.data.message,
                            type: 'is-danger is-light',
                            duration: 5000
                        })
                    }
                    this.$emit('on-loading', false);
                    this.handleDeleteClose()
                })
        },
        handleDeleteClose() {
            this.show_delete = false
        },
        onConfirmStatusUpdate(status) {
            this.$emit('on-loading', true);
            axios
                .patch('/status/order/' + this.order.id, {
                    status: status
                })
                .then(({data}) => {
                    this.$emit('on-loading', false);
                    this.handleStatusUpdateClose();
                    this.$emit('on-update', {...this.order, status: status})
                    this.$buefy.notification.open({
                        message: data.message,
                        type: 'is-success is-light',
                        duration: 5000,
                    })
                })
                .catch(err => {
                    this.$emit('on-loading', false);
                    this.$buefy.notification.open({
                        message: 'Unable to update the status',
                        type: 'is-danger is-light',
                        duration: 5000,
                    })
                })
        },
        handleStatusUpdateClose() {
            this.show_status_update = false
        }
    }
}
</script>
