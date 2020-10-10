<template>
    <section class="w-full">
        <div class="flex flex-row pl-4 mb-4">
            <b-field grouped custom-class="dates">
                <b-field
                    label="Issue Date"
                    custom-class="text-sm"
                    :type="has_issue_date ? 'is-danger' :null"
                    :message="has_issue_date ? 'This field is required' : null"
                >
                    <b-datepicker
                        v-model="order.issue_date"
                        :show-week-number="false"
                        :locale="undefined"
                        placeholder="Click to select..."
                        icon="calendar-today"
                        trap-focus
                        custom-class="text-sm"
                    />
                </b-field>
                <span class="px-2"></span>
                <b-field label="Due Date" custom-class="text-sm">
                    <b-datepicker
                        v-model="order.due_date"
                        :show-week-number="false"
                        :locale="undefined"
                        placeholder="Click to select..."
                        icon="calendar-today"
                        trap-focus
                        custom-class="text-sm"
                    />
                </b-field>
            </b-field>
        </div>
        <div class="pl-1 mb-4 border-t pt-4">
            <template>
                <b-button
                    type="is-info"
                    size="is-small"
                    class="font-medium tracking-wider"
                    @click="toggleAddNewItemModel"
                    v-text="'Add Item'"
                />
                <AddItem :show="show_add_new" @on-add="handleAddNewItem" @on-close="toggleAddNewItemModel"/>
            </template>
        </div>
        <b-table
            :data="products"
            :narrowed="true"
            :hoverable="true"
        >
            <b-table-column
                label="Item"
                v-slot="props"
                width="150"
                cell-class="align-middle"
                header-class="text-sm"
            >
                <EditableDescription
                    placeholder="Write something..."
                    :value="props.row.name"
                    :id="props.row.id"
                    :editable="props.row.edit"
                    @on-input="handleEditName"
                />
            </b-table-column>
            <b-table-column label="Description" centered v-slot="props" width="150" cell-class="align-middle" header-class="text-sm">
                <EditableDescription
                    placeholder="Write something..."
                    :value="props.row.description"
                    :id="props.row.id"
                    :editable="props.row.edit"
                    @on-input="handleEditDescription"
                />
            </b-table-column>
            <b-table-column label="Qty" centered v-slot="props" width="80" cell-class="align-middle" header-class="text-sm">
                <EditableInput
                    placeholder="#"
                    :value="props.row.quantity"
                    :id="props.row.id"
                    :editable="props.row.edit"
                    @on-input="handleEditQuantity"
                />
            </b-table-column>
            <b-table-column
                label="Cost"
                centered
                v-slot="props"
                cell-class="align-middle"
                header-class="text-sm"
            >
                <EditableInput
                    placeholder="0.0%"
                    :value="props.row.buying_unit_cost"
                    :id="props.row.id"
                    :editable="props.row.edit"
                    @on-input="handleEditUnitCost"
                />
            </b-table-column>
            <b-table-column label="Tax %" centered v-slot="props" width="80" cell-class="align-middle" header-class="text-sm">
                <EditableInput
                    placeholder="0.0"
                    :value="props.row.tax_rate"
                    :id="props.row.id"
                    :editable="props.row.edit"
                    unit="%"
                    @on-input="handleEditTaxRate"
                />
            </b-table-column>
            <b-table-column label="Total" centered v-slot="props" cell-class="align-middle" header-class="text-sm">
                <span class="text-sm">{{ props.row.total_buying_cost }}</span>
            </b-table-column>
            <b-table-column v-slot="props" cell-class="align-middle" v-if="!read_only">
                <div class="flex justify-end">
                    <b-button
                        v-if="props.row.edit"
                        type="is-success is-light "
                        class="text-lg h-8 w-8 p-4"
                        icon-right="check"
                        @click="()=>handleSaveRecord(props.row)"
                    />
                    <b-button
                        v-else
                        type="is-info is-light "
                        class="text-lg h-8 w-8 p-4"
                        icon-right="lead-pencil"
                        @click="()=>handleEditRecord(props.row)"
                    />
                    &nbsp; &nbsp;
                    <b-button
                        type="is-danger is-light"
                        class="text-lg h-8 w-8 p-4"
                        icon-right="trash-can-outline"
                        @click="()=>deleteSelectedProducts(props.row)"
                    />
                </div>
            </b-table-column>
            <template slot="footer">
                <EmptyTable v-if="!data.length" message="Add an Item"/>
                <th v-else class="pt-0" colspan="7">
                    <section class="grid grid-col-5 gap-4 w-full border-t">
                        <div class="col-start-4 col-span-2 mt-4">
                            <table class="table is-narrow w-full">
                                <tbody>
                                <tr>
                                    <td class="border-t-0 border-b text-base font-normal">Sub Total</td>
                                    <td class="border-t-0 border-b text-base font-normal">{{ sub_total }}</td>
                                </tr>
                                <tr>
                                    <td class="border-t-0 border-b text-base font-normal">Total Tax</td>
                                    <td class="border-t-0 border-b text-base font-normal">{{ tax }}</td>
                                </tr>
                                <tr>
                                    <td class="border-t-0 text-lg">Total</td>
                                    <td class="border-t-0 text-lg">{{ total }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </th>
            </template>
        </b-table>
    </section>
</template>

<script>
import ProductLookupInput from "@/components/global/lookup/products/ProductLookupInput";
import EditableInput from "@/components/global/input/ProductEditableInput";
import EditableDescription from "@/components/global/input/ProductEditableDescription";
import EmptyTable from '@/components/global/table/EmptyTable'
import AddItem from "./AddItem";

export default {
    components: {AddItem, EditableInput, EmptyTable, EditableDescription, ProductLookupInput},
    props: {
        item: Object | Array,
        editable: {
            type: Boolean,
            default: true
        }
    },
    data() {
        return {
            data: [],
            show_add_new: false,
            required_fields: {
                issue_date: true,
                products: true,
                payment_date: true,
                amount: true,
            },
            errors: {},
        };
    },
    methods: {
        validation() {
            let error_bag = {}
            for (let value in this.order) {
                if (this.required_fields[value] && this.order[value] == null) {
                    error_bag[value] = true;
                }
            }
            if (!this.products.length) {
                error_bag['products'] = true;
            }
            this.errors = error_bag;
        },
        collectData({validate}) {
            this.resetErrors()
            if (validate) {
                this.validation()
            }
            return {
                data: {
                    issue_date: this.order.issue_date ? this.order.issue_date.toLocaleDateString() : null,
                    due_date: this.order.due_date ? this.order.due_date.toLocaleDateString() : null,
                    products: this.products,
                    total_amount: this.total,
                    total_due: this.total_due,
                    total_tax: this.tax,
                    sub_total: this.sub_total,
                },
                errors: this.errors
            }
        },
        resetErrors() {
            this.errors = {}
        },
        handleEditQuantity(value, product_id) {
            const expenses = _.findIndex(this.data, value => value.id == product_id)
            if (expenses !== -1) {
                this.data[expenses] = {
                    ...this.data[expenses],
                    quantity: value,
                    total_buying_cost: this.calculateProductTotalPrice(value, this.data[expenses].buying_unit_cost)
                }
                this.data = [...this.data]
            }
        },
        handleEditUnitCost(value, product_id) {
            const expenses = _.findIndex(this.data, value => value.id == product_id)
            if (expenses !== -1) {
                this.data[expenses] = {
                    ...this.data[expenses],
                    buying_unit_cost: value,
                    total_buying_cost: this.calculateProductTotalPrice(this.data[expenses].quantity, value)
                }
                this.data = [...this.data]
            }
        },
        handleEditTaxRate(value, product_id) {
            const expenses = _.findIndex(this.data, value => value.id == product_id)
            if (expenses !== -1) {
                this.data[expenses] = {...this.data[expenses], tax_rate: value}
                this.data = [...this.data]
            }
        },
        handleEditName(value, product_id) {
            const expenses = _.findIndex(this.data, value => value.id == product_id)
            if (expenses !== -1) {
                this.data[expenses] = {...this.data[expenses], name: value}
                this.data = [...this.data]
            }
        },
        handleEditDescription(value, product_id) {
            const expenses = _.findIndex(this.data, value => value.id == product_id)
            if (expenses !== -1) {
                this.data[expenses] = {...this.data[expenses], description: value}
                this.data = [...this.data]
            }
        },
        handleEditRecord(product) {
            this.updateEditField(product, true)
        },
        handleSaveRecord(product) {
            this.updateEditField(product, false)
        },
        updateEditField(product, editable) {
            const expenses = _.findIndex(this.data, value => value.id == product.id)
            if (expenses !== -1) {
                this.data[expenses] = {...this.data[expenses], edit: editable}
                this.data = [...this.data]
            }
        },
        calculateProductTotalPrice(quantity, buying_unit_cost) {
            return _.round(buying_unit_cost * quantity, 2);
        },
        deleteSelectedProducts(product) {
            this.data = [..._.filter(this.data, value => value.id !== product.id)]
        },
        handleAddNewItem(item) {
            this.data = [...this.products, item]
            this.$emit('on-add-product', {
                total_amount: this.total,
                products: this.data
            })
        },
        toggleAddNewItemModel() {
            this.show_add_new = !this.show_add_new
        }
    },
    computed: {
        products() {
            return this.data
        },
        sub_total() {
            return _.round(_.sumBy(this.products, 'total_buying_cost'), 2);
        },
        tax() {
            return _.sumBy(this.products, value => {
                if (value.tax_rate) {
                    return _.round(value.total_buying_cost * (value.tax_rate / 100), 2);
                }
                return 0.0;
            });
        },
        total() {
            return parseFloat(_.round(this.sub_total + this.tax, 2));
        },
        total_due() {
            return 0
        },
        has_issue_date() {
            return this.errors.issue_date !== undefined
        },
        has_products() {
            return this.errors.products !== undefined
        },
        order() {
            if (this.$props.item) {
                return {
                    issue_date: this.$props.item.issue_date ? new Date(this.$props.item.issue_date) : new Date(),
                    due_date: this.$props.item.due_date ? new Date(this.$props.item.due_date) : null,
                }
            }
            return {
                issue_date: new Date(),
                due_date: null,
            }
        },
        read_only() {
            if (_.isEmpty(this.$props.item)) {
                return false;
            }
            return this.$props.item.status !== 'draft'
        }
    },
    watch: {
        item(value) {
            this.data = value.products ? value.products : []
        }
    }
};
</script>

<style>
.table-footer th {
    border-color: transparent !important;
}

.dates .dropdown-item.active, .dropdown-item:active {
    background-color: transparent !important;
}
</style>
