import {remove} from "@/repos/bills";

const actions = {
    methods: {
        onConfirmDelete() {
            this.$emit('on-loading', true);
            remove(this.$props.bill.id)
                .then(({data}) => {
                    this.$emit('on-loading', false);
                    this.$buefy.notification.open({
                        message: data.message,
                        type: 'is-success is-light',
                        duration: 5000
                    });
                    this.handleDeleteClose()
                    this.$router.push('/@/bills');
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
        handlePrint() {
            this.downloading = true
            axios
                .request({
                    url: '/print/bill/' + this.$props.bill.id,
                    method: 'GET',
                    responseType: 'blob',
                })
                .then(({data}) => {
                    this.downloading = false
                    const downloadUrl = window.URL.createObjectURL(new Blob([data]));
                    const link = document.createElement('a');
                    link.href = downloadUrl;
                    link.setAttribute('download', 'bill' + this.$props.bill.bill_number + '.pdf');
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

export default actions
