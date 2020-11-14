<template>
    <section class="pt-4 step-box">
        <component :is="table_component" :data="$props.records" @on-delete="handleDelete"></component>
    </section>
</template>

<script>
import ProductsTable from "./ProductsTable";
import ClientsTable from "./ClientsTable";
import SuppliersTable from "./SuppliersTable";

export default {
    name: "Confirmation",
    components: {
        ProductsTable, ClientsTable, SuppliersTable
    },
    props: {
        type: String,
        records: Array
    },
    computed: {
        table_component() {
            const MAP = {
                products: ProductsTable,
                clients: ClientsTable,
                suppliers: SuppliersTable,
            }

            return MAP[this.$props.type]
        }
    },
    methods: {
        handleDelete(new_records) {
            this.$emit('on-delete', new_records)
        }
    }
}
</script>

<style>
.import-data-table table th,
.import-data-table table td{
    font-size: 14px !important;
}
</style>
