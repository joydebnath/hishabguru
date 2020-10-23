<template>
    <svg :class="$props.custom_class" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
        <rect x="3" y="5" width="18" height="14" rx="2" stroke="#000" stroke-width="1.5" stroke-linecap="round"
              stroke-linejoin="round"></rect>
        <circle cx="15" cy="13" r="2" stroke="#000" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round"></circle>
        <path
            d="M13.3229 11.5C12.9703 11.1888 12.5072 11 12 11C10.8954 11 10 11.8954 10 13C10 14.1046 10.8954 15 12 15C12.5072 15 12.9703 14.8112 13.3229 14.5"
            stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
</template>

<script>
export default {
    name: "CreditCard",
    props: {
        custom_class: String
    }
}
</script>

<style scoped>

</style>
