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
        payment_history_action_text() {
            return (this.show_payment_history ? 'Close' : 'Read') + ' Payment Histories'
        },
        computed_payment_histories() {
            return this.payment_histories
        },
        computed_loading_payment_histories() {
            return this.loading_payment_histories
        }
    },
    methods: {
        handleReadPH() {
            this.show_payment_history = true;
            if (this.payment_histories.length === 0) {
                this.loadPaymentHistories()
            }
        },
        loadPaymentHistories() {
            this.loading_payment_histories = true;
            axios
                .get('/payment-histories', {
                    params: {
                        payable: 'bill'
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
        handleAddPaymentRecord({paid_amount, history}) {
            this.show_add_payment = false;
            this.bill = {...this.bill, total_due: this.bill.total_due - paid_amount}
            if (history) {
                this.payment_histories = [...this.payment_histories, history]
            }
        }
    }
}

export default histories
