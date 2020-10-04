<template>
    <b-modal
        v-model="$props.show"
        has-modal-card
        :can-cancel="['x']"
        :destroy-on-hide="false"
    >
        <div class="modal-card" style="width: 500px">
            <header class="modal-card-head">
                <p class="modal-card-title">Add Item</p>
                <button class="delete" @click="$emit('on-close')"></button>
            </header>
            <section class="modal-card-body h-auto">
                <b-field
                    label="Name"
                    :type="errors.name ? 'is-danger' : ''"
                    :message="errors.name ? 'Please enter name': ''"
                >
                    <b-input
                        v-model="record.name"
                        placeholder="e.g. HishabGuru subscription"
                    >
                    </b-input>
                </b-field>
                <b-field
                    label="Quantity"
                    :type="errors.quantity ? 'is-danger' : ''"
                    :message="errors.quantity ? 'Please enter quantity': ''"
                >
                    <b-input
                        type="number"
                        v-model="record.quantity"
                        placeholder="e.g. 10"
                        :min="1"
                    >
                    </b-input>
                </b-field>
                <b-field
                    label="Cost"
                    :type="errors.buying_unit_cost ? 'is-danger' : ''"
                    :message="errors.buying_unit_cost ? 'Please enter buying_unit_cost': ''"
                >
                    <b-input
                        type="number"
                        v-model="record.buying_unit_cost"
                        placeholder="e.g. 1000"
                        :min="0"
                    >
                    </b-input>
                </b-field>
                <b-field
                    label="Tax rate"
                    :type="errors.tax_rate ? 'is-danger' : ''"
                    :message="errors.tax_rate ? 'Please enter tax rate': ''"
                >
                    <b-input
                        type="number"
                        v-model="record.tax_rate"
                        placeholder="e.g. 15"
                        :min="0"
                    >
                    </b-input>
                </b-field>
                <b-field label="Note">
                    <b-input
                        type="textarea"
                        v-model="record.description"
                        :rows="2"
                        placeholder="Description"
                        maxlength="200"
                        has-counter
                    >
                    </b-input>
                </b-field>
                <label class="text-gray-700">Total: {{ total }} {{ $props.currency }}</label>
            </section>
            <footer class="modal-card-foot flex-row-reverse">
                <button class="button is-primary" @click="handleAddRecord">Save</button>
            </footer>
        </div>
    </b-modal>
</template>

<script>
export default {
    name: "AddItem",
    props: {
        show: Boolean,
        currency: {
            type: String,
            default: 'BDT'
        }
    },
    data() {
        return {
            record: {},
            required: {
                name: true,
                quantity: true,
                buying_unit_cost: true
            },
            errors: {}
        }
    },
    methods: {
        handleAddRecord() {
            if (this.hasErrors()) {
                return
            }
            this.$emit('on-add', {...this.record, total_buying_cost: this.total, edit: false})
            this.$emit('on-close')
            this.record = {}
        },
        hasErrors() {
            this.errors = {}

            for (let value in this.required) {
                if (this.record[value] === undefined && this.required[value]) {
                    this.errors[value] = 'This field is required'
                }
            }

            return !_.isEmpty(this.errors)
        }
    },
    computed: {
        total() {
            return this.record.quantity && this.record.buying_unit_cost ?
                (parseFloat(this.record.buying_unit_cost) * parseInt(this.record.quantity)) : 0
        },
        tax() {
            return this.record.tax_rate ? (parseFloat(this.record.tax_rate) / 100) : 0
        }
    }
}
</script>
