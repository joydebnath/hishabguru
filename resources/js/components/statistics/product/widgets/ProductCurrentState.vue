<template>
    <section class="mb-6" v-if="$props.product">
        <h2 class="heading text-right text-lg mb-2">{{ $props.product.name }}</h2>
        <nav class="level box shadow rounded-lg">
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Code</p>
                    <p class="title is-4">#{{ $props.product.code }}</p>
                    <b-skeleton width="60px" height="10" :animated="false" v-if="!$props.product"/>
                </div>
            </div>
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Buying cost</p>
                    <p class="title is-4" v-text="$props.product.cost"></p>
                </div>
            </div>
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Selling price</p>
                    <p class="title is-4" v-text="$props.product.sell"></p>
                </div>
            </div>
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Total Quantity</p>
                    <p class="title is-4" v-text="$props.product.quantity"></p>
                </div>
            </div>
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Category</p>
                    <p class="title is-4">{{ $props.product.category ? $props.product.category.name : '' }}</p>
                </div>
            </div>
        </nav>
    </section>
</template>

<script>
export default {
    name: "ProductCurrentState",
    props: {
        product: Object | Array
    },
}
</script>

<style scoped>

</style>
