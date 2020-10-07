const actions = {
    methods: {
        handleDelete() {
            this.$buefy.dialog.confirm({
                message: '<h5 class="mb-2 font-medium text-xl">Deleting Invoice</h5>Are you sure you want to delete <b>' + this.invoice.invoice_number + '</b> ?',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => {
                    this.$store.dispatch('invoices/delete', {invoice: this.invoice})
                    this.$router.push('/@/invoices');
                }
            })
        },
        handleAddPayment() {
            this.show_add_payment = true
        },
    }
}

export default actions
