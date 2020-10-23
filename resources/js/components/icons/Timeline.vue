<template>
    <svg :class="$props.custom_class" width="24" height="24" viewBox="0 0 24 24" fill="none"
         xmlns="http://www.w3.org/2000/svg">
        <rect x="3" y="3" width="6" height="4" stroke="#000" stroke-width="1.5" stroke-linecap="round"
              stroke-linejoin="round"></rect>
        <rect x="3" y="17" width="8" height="4" stroke="#000" stroke-width="1.5" stroke-linecap="round"
              stroke-linejoin="round"></rect>
        <rect x="7" y="10" width="14" height="4" stroke="#000" stroke-width="1.5" stroke-linecap="round"
              stroke-linejoin="round"></rect>
    </svg>
</template>

<script>
export default {
    name: "Timeline",
    props: {
        custom_class: String
    }
}
</script>

<style scoped>

</style>
