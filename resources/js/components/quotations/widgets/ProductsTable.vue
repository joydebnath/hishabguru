<template>
    <section class="w-full">
        <div class="flex flex-row pl-4 mb-4">
            <b-field grouped custom-class="dates">
                <b-field label="Create Date">
                    <b-datepicker
                        v-model="create_date"
                        :show-week-number="showWeekNumber"
                        :locale="locale"
                        placeholder="Click to select..."
                        icon="calendar-today"
                        trap-focus>
                    </b-datepicker>
                </b-field>
                <span class="px-2"></span>
                <b-field label="Expiry Date">
                    <b-datepicker
                        v-model="expiry_date"
                        :show-week-number="showWeekNumber"
                        :locale="locale"
                        placeholder="Click to select..."
                        icon="calendar-today"
                        trap-focus>
                    </b-datepicker>
                </b-field>
            </b-field>
        </div>
        <div class="pl-4 mb-4 relative">
            <ProductLookupInput/>
        </div>
        <b-table
            :data="products"
        >
            <b-table-column
                field="user.first_name"
                label="Product"
                v-slot="props"
                width="200"
            >
                {{ props.row.user.first_name }}
            </b-table-column>

            <b-table-column label="Qty" centered v-slot="props" width="80">
                <EditableInput placeholder="#" :editable="props.row.edit" @on-input="()=>{}"/>
            </b-table-column>
            <b-table-column
                label="Unit Price"
                centered
                v-slot="props"
            >
                600
            </b-table-column>
            <b-table-column
                label="Disc %"
                centered
                v-slot="props"
                width="80"
            >
                <EditableInput placeholder="0.0%" :editable="props.row.edit" @on-input="()=>{}"/>
            </b-table-column>

            <b-table-column label="Tax" centered v-slot="props" width="80">
                <EditableInput placeholder="0.0" :editable="props.row.edit" @on-input="()=>{}"/>
            </b-table-column>
            <b-table-column label="Total" centered v-slot="props">
                1200
            </b-table-column>
            <b-table-column v-slot="props">
                <div class="flex justify-end">
                    <b-button
                        v-if="props.row.edit"
                        type="is-success is-light "
                        class="text-lg h-8 w-8  p-4"
                        icon-right="check"
                        @click="()=>handleSaveRecord(props.row)"
                    />
                    <b-button
                        v-else
                        type="is-info is-light "
                        class="text-lg h-8 w-8  p-4"
                        icon-right="lead-pencil"
                        @click="()=>handleEditRecord(props.row)"
                    />

                    &nbsp; &nbsp;
                    <b-button
                        type="is-danger is-light"
                        class="text-lg h-8 w-8  p-4"
                        icon-right="trash-can-outline"
                    />
                </div>
            </b-table-column>
            <!--            <template slot="footer" >-->
            <!--                -->
            <!--            </template>-->
        </b-table>
    </section>
</template>

<script>
import ProductLookupInput from "./products/ProductLookupInput";
import EditableInput from "../../global/input/EditableInput";

export default {
    components: {EditableInput, ProductLookupInput},
    data() {
        return {
            data: [
                {
                    id: 1,
                    user: {first_name: "Joy", last_name: "Debnath"},
                    date: "2020-03-28",
                    gender: "male",
                    edit: false
                },
            ],
            create_date: new Date(),
            expiry_date: null,
            showWeekNumber: false,
            locale: undefined
        };
    },
    methods: {
        handleEditRecord(product) {
            this.modifyEditField(product, true)
        },
        handleSaveRecord(product) {
            this.modifyEditField(product, false)
        },
        modifyEditField(product, editable) {
            const index = _.findIndex(this.data, value => value.id == product.id)
            if (index !== -1) {
                this.data[index] = {...this.data[index], edit: editable}
                this.data = [...this.data]
            }
        }
    },
    computed: {
        products() {
            return this.data
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
