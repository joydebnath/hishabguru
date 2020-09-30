<template>
    <ul class="border border-gray-200 rounded-md">
        <File v-for="(file, bills) in $props.files" :key="bills" :name="file.name"/>
    </ul>
</template>

<script>
import File from "./File";

export default {
    name: "FileLists",
    components: {File},
    props: {
        files: Object | Array
    }
}
</script>

<style scoped>

</style>
