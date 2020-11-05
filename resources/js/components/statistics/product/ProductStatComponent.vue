<template>
    <section class="max-w-6xl m-auto w-full mb-6 py-2">
        <b-loading :is-full-page="true" v-model="loading" :can-cancel="false"/>
        <template v-if="!loading">
            <ProductCurrentState :product="product"/>
            <Last12MonthsChart :product_id="product_id"/>
            <SellHistoriesTable :product_id="product_id"/>
            <PurchaseHistoriesTable :product_id="product_id"/>
        </template>
    </section>
</template>

<script>

import Last12MonthsChart from "./widgets/Last12MonthsChart";
import ProductCurrentState from "./widgets/ProductCurrentState";
import SellHistoriesTable from "./widgets/SellHistoriesTable";
import PurchaseHistoriesTable from "./widgets/PurchaseHistoriesTable";

export default {
    name: "ProductStatComponent",
    components: {
        SellHistoriesTable,
        ProductCurrentState,
        Last12MonthsChart,
        PurchaseHistoriesTable
    },
    mounted() {
        this.product_id = this.$route.params.id;
        this.loading = true
        axios
            .get('/products/' + this.$route.params.id)
            .then(({data}) => {
                this.product = data.data
                this.loading = false
            })
            .catch(err => {
                console.log(err)
                this.loading = false
                this.$router.push('/@/products');
            })
    },
    data() {
        return {
            product: {},
            product_id: null,
            loading: false
        }
    }
}
</script>

