<template>
    <div class="flex flex-row-reverse">
        <div>
            <!--            <b-dropdown aria-role="list">-->
            <!--                <button class="button is-light is-small" slot="trigger" slot-scope="{ active }">-->
            <!--                    <span>Actions</span>-->
            <!--                    <svg v-if="active" class="h-4" width="24" height="24" viewBox="0 0 24 24" fill="none"-->
            <!--                         xmlns="http://www.w3.org/2000/svg">-->
            <!--                        <path d="M4 16L12 8L20 16" stroke="#000" stroke-width="1.5" stroke-linecap="round"-->
            <!--                              stroke-linejoin="round"></path>-->
            <!--                    </svg>-->
            <!--                    <svg v-else class="h-4" width="24" height="24" viewBox="0 0 24 24" fill="none"-->
            <!--                         xmlns="http://www.w3.org/2000/svg">-->
            <!--                        <path d="M4 8L12 16L20 8" stroke="#000" stroke-width="1.5" stroke-linecap="round"-->
            <!--                              stroke-linejoin="round"></path>-->
            <!--                    </svg>-->
            <!--                </button>-->

            <!--                <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>-->
            <!--                <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>-->
            <!--                <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>-->
            <!--            </b-dropdown>-->
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
    </div>
</template>

<script>
export default {
    name: "HeaderActions",
    props: {
        invoice: Array | Object,
    },
    data() {
        return {
            loading: false,
            downloading: false,
        }
    },
    methods: {
        handlePrint() {
            this.downloading = true
            axios
                .request({
                    url: '/print/invoice/' + this.$props.invoice._id,
                    method: 'GET',
                    responseType: 'blob',
                })
                .then(({data}) => {
                    this.downloading = false
                    const downloadUrl = window.URL.createObjectURL(new Blob([data]));
                    const link = document.createElement('a');
                    link.href = downloadUrl;
                    link.setAttribute('download', 'invoice' + this.$props.invoice.invoice_number + '.pdf');
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
    }
}
</script>

<style>
.modal-card-body .is-titleless,
.modal-card-foot {
    padding: 10px 15px;
}
</style>
