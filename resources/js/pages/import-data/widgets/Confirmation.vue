<template>
    <section class="pt-4 step-box">
        <component :is="table_component" :data="$props.records"></component>
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
    }
}
</script>

<style scoped>

</style>
