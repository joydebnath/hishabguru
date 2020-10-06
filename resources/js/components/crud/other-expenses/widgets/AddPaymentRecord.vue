<template>
    <b-modal
        v-model="$props.show"
        has-modal-card
        :can-cancel="['x']"
        :destroy-on-hide="false"
    >
        <b-loading :is-full-page="false" v-model="loading" :can-cancel="false"/>
        <div class="modal-card" style="width: 400px">
            <header class="modal-card-head">
                <p class="modal-card-title">Add Payment Record</p>
                <button class="delete" @click="$emit('on-close')"></button>
            </header>
            <section class="modal-card-body h-auto">
                <b-field
                    label="Payment Date"
                    :type="errors.payment_date ? 'is-danger' : ''"
                    :message="errors.payment_date ? 'Please select the payment date': ''"
                    grouped
                >
                    <b-datepicker size="is-small" v-model="payment_record.payment_date" :mobile-native="false">
                        <template v-slot:trigger>
                            <b-button
                                icon-left="calendar-today"
                                type="is-warning"
                            />
                        </template>
                    </b-datepicker>
                    <b-input
                        expanded readonly
                        :value="selectedString"
                        placeholder="Select payment date"
                    />
                </b-field>
                <b-field
                    label="Amount Paid"
                    :type="errors.amount ? 'is-danger' : ''"
                    :message="errors.amount ? 'Please enter a valid payment amount': ''"
                >
                    <b-input
                        type="number"
                        v-model="payment_record.amount"
                        placeholder="e.g. 1000"
                        :min="0"
                        :max="$props.due_amount"
                    >
                    </b-input>
                </b-field>
                <b-field label="Note">
                    <b-input
                        type="textarea"
                        v-model="payment_record.note"
                        placeholder="e.g. Paid through BKash"
                        maxlength="200"
                        has-counter
                    >
                    </b-input>
                </b-field>
                <label class="text-gray-700" v-if="$props.due_amount">
                    Amount Remaining: {{ $props.due_amount }} {{ $props.currency }}
                </label>
            </section>
            <footer class="modal-card-foot flex-row-reverse">
                <button class="button is-primary" @click="handleAddRecord">Save</button>
            </footer>
        </div>
    </b-modal>
</template>

<script>
export default {
    name: "AddPaymentRecord",
    props: {
        show: Boolean,
        due_amount: String | Number,
        currency: {
            type: String,
            default: 'BDT'
        }
    },
    data() {
        return {
            payment_record: {},
            loading: false,
            required: {
                payment_date: true,
                amount: true,
            },
            errors: {}
        }
    },
    methods: {
        handleAddRecord() {
            if (this.hasErrors()) {
                return
            }

            this.loading = true

            axios
                .post('/payment-histories', {
                    ...this.payment_record,
                    payment_date: this.payment_record.payment_date ? this.payment_record.payment_date.toLocaleDateString() : null,
                    payable_type: 'other-expenses',
                    payable_id: this.$route.params.id,
                })
                .then(({data}) => {
                    this.loading = false
                    this.payment_record = {}
                    this.$emit('on-add-record', {total_due: data.data.total_due, history: data.data})
                })
                .catch(err => {
                    this.loading = false
                })
        },
        hasErrors() {
            this.errors = {}

            for (let value in this.required) {
                if (this.payment_record[value] === undefined && this.required[value]) {
                    this.errors[value] = 'This field is required'
                }
            }

            if (parseFloat(this.payment_record['amount']) > parseFloat(this.$props.due_amount)) {
                this.errors['amount'] = 'Invalid value'
            }

            return !_.isEmpty(this.errors)
        }
    },
    computed: {
        selectedString() {
            return this.payment_record.payment_date ? this.payment_record.payment_date.toLocaleDateString() : ''
        }
    }
}
</script>

<style scoped>

</style>
