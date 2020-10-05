<template>
    <div class="pl-1 mb-4 border-t pt-2">
        <p class="mb-2 flex flex-row align-items-center">
            <b-switch v-model="show_row">
                <span class="font-medium tracking-wider ">
                    Add Payment Record
                </span>
            </b-switch>
        </p>
        <div class="grid grid-cols-3 gap-4" v-if="show_row">
            <b-field
                custom-class="text-sm"
                label="Amount"
                :type="errors.amount ? 'is-danger' : ''"
                :message="errors.amount ? 'Please enter paid amount': ''"
            >
                <b-input

                    type="number"
                    placeholder="e.g. 15"
                    :min="0"
                    v-model="payment_record.amount"
                >
                </b-input>
            </b-field>
            <b-field
                custom-class="text-sm"
                label="Payment Date"
                grouped
                :type="errors.payment_date ? 'is-danger' : ''"
                :message="errors.payment_date ? 'Please select payment date': ''"
            >
                <b-datepicker v-model="payment_record.payment_date" :mobile-native="false" position="is-top-right">
                    <template v-slot:trigger>
                        <b-button
                            icon-left="calendar-today"
                            type="is-warning"
                        />
                    </template>
                </b-datepicker>
                <b-input
                    expanded readonly
                    placeholder="Select payment date"
                    :value="selectedString"
                />
            </b-field>
            <b-field
                custom-class="text-sm"
                label="Note"
            >
                <b-input
                    placeholder="e.g. 15"
                    :min="0"
                    v-model="payment_record.payment_note"
                >
                </b-input>
            </b-field>
        </div>
    </div>
</template>

<script>
export default {
    name: "AdInlinedPaymentRecord",
    data() {
        return {
            payment_record: {},
            show_row: false,
            required: {
                amount: true,
                payment_date: true,
            },
            errors: {}
        }
    },
    methods: {
        collectData({validate}) {
            if (validate && this.show_row) {
                this.hasErrors()
            }
            if (this.payment_record.payment_date) {
                this.payment_record['payment_date'] = this.payment_record.payment_date.toLocaleDateString()
            }
            return {
                data: {
                    payment: this.payment_record
                },
                errors: this.errors
            }
        },
        hasErrors() {
            this.errors = {}

            for (let value in this.required) {
                if (this.payment_record[value] === undefined && this.required[value]) {
                    this.errors[value] = true
                }
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
