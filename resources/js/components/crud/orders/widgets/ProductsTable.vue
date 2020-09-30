<template>
    <section class="w-full">
        <div class="flex flex-row pl-4 mb-4">
            <b-field grouped custom-class="dates">
                <b-field
                    label="Create Date"
                    :type="has_create_date ? 'is-danger' :null"
                    :message="has_create_date ? 'This field is required' : null"
                >
                    <b-datepicker
                        v-model="order.create_date"
                        :show-week-number="false"
                        :locale="undefined"
                        placeholder="Click to select..."
                        icon="calendar-today"
                        trap-focus
                    />
                </b-field>
                <span class="px-2"></span>
                <b-field label="Delivery Date">
                    <b-datepicker
                        v-model="order.delivery_date"
                        :show-week-number="false"
                        :locale="undefined"
                        placeholder="Click to select..."
                        icon="calendar-today"
                        trap-focus
                    />
                </b-field>
            </b-field>
        </div>
        <div class="pl-4 mb-4 relative border-t pt-4">
            <ProductLookupInput @on-select="handleProductSelect"/>
        </div>
        <b-table
            :data="products"
            :narrowed="true"
            :hoverable="true"
        >
            <b-table-column
                label="Product"
                v-slot="props"
                width="200"
                cell-class="align-middle"
            >
                <p class="m-0 flex flex-col">
                    <small class="text-xs">{{ props.row.code }}</small>
                    <span class="text-sm">{{ props.row.name }}</span>
                </p>
            </b-table-column>
            <b-table-column label="Qty" centered v-slot="props" width="80" cell-class="align-middle">
                <EditableInput
                    placeholder="#"
                    :value="props.row.quantity"
                    :id="props.row.id"
                    :editable="props.row.edit"
                    @on-input="handleEditQuantity"
                />
            </b-table-column>
            <b-table-column
                label="Unit Price"
                centered
                v-slot="props"
                cell-class="align-middle"
            >
                <span class="text-sm">{{ props.row.selling_unit_price }}</span>
            </b-table-column>
            <b-table-column
                label="Disc %"
                centered
                v-slot="props"
                width="80"
                cell-class="align-middle"
            >
                <EditableInput
                    placeholder="0.0%"
                    :value="props.row.discount"
                    :id="props.row.id"
                    :editable="props.row.edit"
                    @on-input="handleEditDiscount"
                />
            </b-table-column>
            <b-table-column label="Tax" centered v-slot="props" width="80" cell-class="align-middle">
                <EditableInput
                    placeholder="0.0"
                    :value="props.row.tax_rate"
                    :id="props.row.id"
                    :editable="props.row.edit"
                    @on-input="handleEditTaxRate"
                />
            </b-table-column>
            <b-table-column label="Total" centered v-slot="props" cell-class="align-middle">
                <span class="text-sm">{{ props.row.total }}</span>
            </b-table-column>
            <b-table-column v-slot="props" cell-class="align-middle">
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
                <EmptyTable v-if="!data.length" message="Add a product"/>
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
import ProductLookupInput from "./products/ProductLookupInput";
import EditableInput from "@/components/global/input/ProductEditableInput";
import EmptyTable from '@/components/global/table/EmptyTable'

export default {
    components: {EditableInput, EmptyTable, ProductLookupInput},
    props: {
        item: Object | Array
    },
    data() {
        return {
            data: [],
            required_fields: {
                create_date: true,
                products: true
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
                    create_date: this.order.create_date ? this.order.create_date.toLocaleDateString() : null,
                    delivery_date: this.order.delivery_date ? this.order.delivery_date.toLocaleDateString() : null,
                    products: this.products,
                    total_amount: this.total,
                    total_tax: this.tax,
                    sub_total: this.sub_total,
                },
                errors: this.errors
            }
        },
        resetErrors() {
            this.errors = {}
        },
        handleProductSelect(product) {
            const INDEX = _.findIndex(this.data, value => value.id === product.id)
            if (INDEX === -1) {
                this.data = [...this.data, product];
                return;
            }
            const new_quantity = parseInt(this.data[INDEX].quantity) + parseInt(product.quantity);
            this.data[INDEX] = {
                ...this.data[INDEX],
                quantity: new_quantity,
                total: new_quantity * product.selling_unit_price,
            }
            this.data = [...this.data];
        },
        handleEditQuantity(value, product_id) {
            const index = _.findIndex(this.data, value => value.id == product_id)
            if (index !== -1) {
                this.data[index] = {
                    ...this.data[index],
                    quantity: value,
                    total: this.calculateProductTotalPrice(value, this.data[index].selling_unit_price, this.data[index].discount)
                }
                this.data = [...this.data]
            }
        },
        handleEditDiscount(value, product_id) {
            const index = _.findIndex(this.data, value => value.id == product_id)
            if (index !== -1) {
                this.data[index] = {
                    ...this.data[index],
                    discount: value,
                    total: this.calculateProductTotalPrice(this.data[index].quantity, this.data[index].selling_unit_price, value)
                }
                this.data = [...this.data]
            }
        },
        handleEditTaxRate(value, product_id) {
            const index = _.findIndex(this.data, value => value.id == product_id)
            if (index !== -1) {
                this.data[index] = {...this.data[index], tax_rate: value}
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
            const index = _.findIndex(this.data, value => value.id == product.id)
            if (index !== -1) {
                this.data[index] = {...this.data[index], edit: editable}
                this.data = [...this.data]
            }
        },
        calculateProductTotalPrice(quantity, selling_unit_price, discount) {
            let total = selling_unit_price * quantity
            if (discount) {
                total = total - (total * (discount / 100));
            }
            return _.round(total, 2);
        },
        deleteSelectedProducts(product) {
            this.data = [..._.filter(this.data, value => value.id !== product.id)]
        },
    },
    computed: {
        products() {
            return this.data
        },
        sub_total() {
            return _.round(_.sumBy(this.products, 'total'), 2);
        },
        tax() {
            return _.sumBy(this.products, value => {
                if (value.tax_rate) {
                    return _.round(value.total * (value.tax_rate / 100), 2);
                }
                return 0.0;
            });
        },
        total() {
            return parseFloat(_.round(this.sub_total + this.tax, 2));
        },
        has_create_date() {
            return this.errors.create_date !== undefined
        },
        has_products() {
            return this.errors.products !== undefined
        },
        order() {
            if (this.$props.item) {
                return {
                    create_date: this.$props.item.create_date ? new Date(this.$props.item.create_date) : new Date(),
                    delivery_date: this.$props.item.delivery_date ? new Date(this.$props.item.delivery_date) : null,
                }
            }
            return {
                create_date: new Date(),
                delivery_date: null,
            }
        },
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
