<template>
    <svg :class="$props.custom_class" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
        <path d="M4.22222 6H19.7778L22 9.5V13H2V9.5L4.22222 6Z" stroke="#000" stroke-width="1.5" stroke-linecap="round"
              stroke-linejoin="round"></path>
        <path d="M10 13H20V20C20 20.5523 19.5523 21 19 21H11C10.4477 21 10 20.5523 10 20V13Z" stroke="#000"
              stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
        <path d="M4 13L4 21" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
        <path d="M19 2L5 2" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
</template>

<script>
export default {
    name: "Store",
    props: {
        custom_class: String
    }
}
</script>

<style scoped>

</style>
