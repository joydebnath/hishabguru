const actions = {
    methods: {
        handleDelete() {
            this.$buefy.dialog.confirm({
                message: '<h5 class="mb-2 font-medium text-xl">Deleting Bill</h5>Are you sure you want to delete <b>' + this.bill.bill_number + '</b> ?',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => {
                    this.$store.dispatch('bills/delete', {bill: this.bill})
                    this.$router.push('/@/bills');
                }
            })
        },
        handleAddPayment() {
            this.show_add_payment = true
        },
    }
}

export default actions
