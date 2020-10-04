const actions = {
    methods: {
        handleDelete() {
            this.$buefy.dialog.confirm({
                message: '<h5 class="mb-2 font-medium text-xl">Deleting Expense</h5>Are you sure you want to delete <b>' + this.expnese.expnese_number + '</b> ?',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => {
                    this.$store.dispatch('other_expneses/delete', {bill: this.bill})
                    this.$router.push('/@/other-expneses');
                }
            })
        },
        handleAddPayment() {
            this.show_add_payment = true
        },
    }
}

export default actions
