<template>
    <svg :class="$props.custom_class" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
        <path
            d="M20 10V7C20 5.89543 19.1046 5 18 5H4C2.89543 5 2 5.89543 2 7V17C2 18.1046 2.89543 19 4 19H18C19.1046 19 20 18.1046 20 17V14M22 10H16C14.8954 10 14 10.8954 14 12C14 13.1046 14.8954 14 16 14H22V10Z"
            stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
</template>

<script>
export default {
    name: "Wallet",
    props: {
        custom_class: String
    }
}
</script>

<style scoped>

</style>
