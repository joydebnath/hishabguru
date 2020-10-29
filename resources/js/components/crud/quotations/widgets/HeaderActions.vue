<template>
    <section class="grid grid-cols-2 gaps-4">
        <div class="col-span-1">
            <div class="mb-2 -mt-1">
                <router-link v-for="(link,i) in $props.quotation.copied" :key="link" :to="link">
                    <b-button type="is-link is-light" size="is-small"
                              class="font-semibold rounded-md mr-2 text-uppercase tracking-wide">
                        <b-icon
                            pack="fas"
                            icon="link"
                            size="is-small"
                        />
                        &nbsp;&nbsp;{{ i }}
                    </b-button>
                </router-link>
            </div>
        </div>
        <div class="col-span-1">
            <div class="flex flex-row-reverse mb-1">
                <b-dropdown aria-role="list" append-to-body size="is-small" v-if="true">
                    <button class="button px-2 is-small rounded-md" slot="trigger" slot-scope="{ active }">
                        <span class="font-semibold">Options</span>
                        <b-icon :icon="active ? 'menu-up' : 'menu-down'"/>
                    </button>
                    <b-dropdown-item aria-role="listitem" @click="handleStatusUpdate">
                        Update Status
                    </b-dropdown-item>
                    <b-dropdown-item aria-role="listitem" @click="handleCopy" v-if="computed_copy_to_options.length">
                        Copy To
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
                <CheckBox
                    ref="copy_to"
                    title="Copy quotation to,"
                    :show="copy_to_popup"
                    :loading="loading_copy_to"
                    :options="computed_copy_to_options"
                    :handler="handleCopyTo"
                    @on-close="handleCopyClose"
                />
            </div>
        </div>
    </section>
</template>

<script>
import DownloadingBox from "@/components/global/popups/DownloadingBox";
import UpdateStatusBox from "@/components/global/popups/UpdateStatusBox";
import DeleteBox from "@/components/global/popups/DeleteBox";
import {remove} from '@/repos/quotations'
import CheckBox from "@/components/global/popups/CheckBox";

export default {
    name: "HeaderActions",
    components: {CheckBox, DeleteBox, UpdateStatusBox, DownloadingBox},
    props: {
        quotation: Object
    },
    data() {
        return {
            downloading: false,
            show_status_update: false,
            show_delete: false,
            tobe_copied_quotation: {},
            copy_to_popup: false,
            loading_copy_to: false,
            statuses: [
                {name: 'Accepted', value: 'accepted'},
                {name: 'Declined', value: 'declined'},
                {name: 'Expired', value: 'expired'},
                {name: 'Invoiced', value: 'invoiced'},
            ]
        }
    },
    computed: {
        computed_copy_to_options() {
            let copy_to_options = [
                {value: 'orders', name: 'A new Order'},
                {value: 'invoices', name: 'A new Invoice'},
            ];
            if (this.$props.quotation.copied && this.$props.quotation.copied.order) {
                copy_to_options = [..._.filter(copy_to_options, item => item.value !== 'orders')]
            }
            if (this.$props.quotation.copied && this.$props.quotation.copied.invoice) {
                copy_to_options = [..._.filter(copy_to_options, item => item.value !== 'invoices')]
            }
            return copy_to_options;
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
                    url: '/print/quotation/' + this.$props.quotation.id,
                    method: 'GET',
                    responseType: 'blob',
                })
                .then(({data}) => {
                    this.downloading = false
                    const downloadUrl = window.URL.createObjectURL(new Blob([data]));
                    const link = document.createElement('a');
                    link.href = downloadUrl;
                    link.setAttribute('download', 'quotation' + this.$props.quotation.quotation_number + '.pdf');
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
            remove(this.$props.quotation.id)
                .then(({data}) => {
                    this.$emit('on-loading', false);
                    this.$buefy.notification.open({
                        message: data.message,
                        type: 'is-success is-light',
                        duration: 5000
                    });
                    this.handleDeleteClose()
                    this.$router.push('/@/quotations');
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
                .patch('/status/quotation/' + this.$props.quotation.id, {
                    status: status
                })
                .then(({data}) => {
                    this.$emit('on-loading', false);
                    this.handleStatusUpdateClose();
                    this.$emit('on-update', {...this.$props.quotation, status: status})
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
        },
        handleCopy() {
            this.copy_to_popup = true;
        },
        handleCopyClose() {
            this.copy_to_popup = false;
            this.loading_copy_to = false;
        },
        handleCopyTo(type) {
            if (type) {
                this.loading_copy_to = true;
                axios
                    .post('/copy-to', {
                        from: 'quotations',
                        to: type,
                        copy_from_id: this.$props.quotation.id
                    })
                    .then(({data}) => {
                        const FIRST = type.shift()
                        const URL = data.data[FIRST]
                        this.$router.push(URL);
                        this.handleCopyClose();
                    })
                    .catch(err => {
                        this.handleCopyClose();
                    })
                this.$refs.copy_to.clearCheckbox();
            }
        },
    }
}
</script>

<style scoped>

</style>
