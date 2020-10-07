const histories = {
    data() {
        return {
            show_add_payment: false,
            payment_histories: []
        }
    },
    computed: {
        computed_payment_histories() {
            return this.payment_histories
        },
        computed_total_due(){
            return this.expense ? this.expense.total_due: 0
        }
    },
    methods: {
        handleAddPaymentRecord({total_due, history}) {
            this.show_add_payment = false;
            this.expense = {...this.expense, total_due: parseFloat(total_due)}
            if (history) {
                this.payment_histories = [...this.payment_histories, history]
            }
        },
        toggleLoadingPH(value) {
            this.loading_payment_histories = value
        },
        handleDeletePH({id, amount}) {
            this.expense = {...this.expense, total_due: parseFloat(this.expense.total_due) + parseFloat(amount)}
            this.payment_histories = [..._.filter(this.payment_histories, value => value.id != id)]
        }
    }
}

export default histories
