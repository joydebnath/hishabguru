<template>
    <div class="flex flex-row justify-content-between -mx-2">
        <div>
            <button class="button is-info tracking-wider uppercase font-medium is-small"
                    @click="() => updateStatus('accepted')"
                    v-if="show_accept_action"
                    :disabled="loading"
            >
                Accept
            </button>
            <button class="button is-danger tracking-wider uppercase font-medium is-outlined is-small"
                    @click="() => updateStatus('declined')"
                    v-if="show_decline_action"
                    :disabled="loading"
            >
                Decline
            </button>
        </div>
        <button class="button is-light is-small" @click="handlePrint" :disabled="downloading">
            <svg class="h-4" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M18 16H21C21.5523 16 22 15.5523 22 15V9C22 8.44772 21.5523 8 21 8H3C2.44772 8 2 8.44772 2 9V15C2 15.5523 2.44772 16 3 16H6"
                    stroke="#000" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round"></path>
                <path d="M6 12H18V20C18 20.5523 17.5523 21 17 21H7C6.44772 21 6 20.5523 6 20V12Z"
                      stroke="#000" stroke-width="1.5" stroke-linecap="round"
                      stroke-linejoin="round"></path>
                <path d="M6 4C6 3.44772 6.44772 3 7 3H17C17.5523 3 18 3.44772 18 4V8H6V4Z" stroke="#000"
                      stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span>Print</span>
        </button>
    </div>
</template>

<script>
export default {
    name: "HeaderActions",
    props: {
        quotation: Array | Object,
    },
    data() {
        return {
            loading: false,
            downloading: false,
        }
    },
    computed: {
        show_accept_action() {
            const STATUSES = ['open', 'declined']
            return _.indexOf(STATUSES, this.$props.quotation.status) !== -1
        },
        show_decline_action() {
            const STATUSES = ['open']
            return _.indexOf(STATUSES, this.$props.quotation.status) !== -1
        },
    },
    methods: {
        handlePrint() {
            this.downloading = true
            axios
                .request({
                    url: '/print/quotation/' + this.$props.quotation._id,
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
        updateStatus(status) {
            const verb = status === 'declined' ? 'decline' : 'accept'
            this.$buefy.dialog.confirm({
                message: 'Are you sure, you want to ' + verb + ' the quotation?',
                type: status === 'declined' ? 'is-danger' : 'is-success',
                onConfirm: () => {
                    this.loading = true
                    axios
                        .post('/quotation/' + this.$props.quotation._id, {
                            status: status
                        })
                        .then(({data}) => {
                            this.$emit('on-update', {status: status})
                            this.loading = false
                        })
                        .catch(err => {
                            console.log(err)
                            this.loading = false
                        })
                }
            })
        }
    }
}
</script>

<style>
.modal-card-body .is-titleless,
.modal-card-foot {
    padding: 10px 15px;
}
</style>
