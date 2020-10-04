const histories = {
    data() {
        return {
            show_payment_history: false,
            show_add_payment: false,
            loading_payment_histories: false,
            payment_histories: []
        }
    },
    computed: {
        computed_payment_histories() {
            return this.payment_histories
        },
        computed_loading_payment_histories() {
            return this.loading_payment_histories
        }
    },
    methods: {
        loadPaymentHistories() {
            this.loading_payment_histories = true;
            axios
                .get('/payment-histories', {
                    params: {
                        payable: 'other-expenses'
                    }
                })
                .then(({data}) => {
                    this.payment_histories = data.data
                    this.loading_payment_histories = false;
                })
                .catch(err => {
                    this.loading_payment_histories = false;
                    console.log(err)
                })
        },
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
            this.payment_histories = [..._.filter(value => value.id !== id)]
        }
    }
}

export default histories
