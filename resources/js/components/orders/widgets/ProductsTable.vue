<template>
    <section class="w-full">
        <div class="pl-4 mb-4 relative">
            <b-input style="width: 40.8%" placeholder="Search and Add Product"></b-input>
            <ProductDropdown />
        </div>
        <b-table
            :data="data"
        >
            <b-table-column
                field="user.first_name"
                label="Product"
                v-slot="props"
                width="200"
            >
                {{ props.row.user.first_name }}
            </b-table-column>

            <b-table-column label="Qty" centered v-slot="props">
                2
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
            >

            </b-table-column>

            <b-table-column label="Tax" centered v-slot="props">

            </b-table-column>
            <b-table-column label="Total" centered v-slot="props">
                1200
            </b-table-column>
            <b-table-column>
                <div class="flex justify-end">
                    <b-button
                        type="is-info is-light "
                        class="text-lg h-8 w-8  p-4"
                        icon-right="lead-pencil"
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
import ProductDropdown from "./products/ProductDropdown";

export default {
    components: {ProductDropdown},
    data() {
        return {
            data: [
                {
                    id: 1,
                    user: {first_name: "Joy", last_name: "Debnath"},
                    date: "2020-03-28",
                    gender: "male"
                },
            ],
        };
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
