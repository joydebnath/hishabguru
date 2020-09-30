<template>
    <div>
        <label class="label">Files</label>
        <FileLists
            :files="[
                {name: 'invoice.pdf'}
            ]"
        />
    </div>
</template>

<script>
import FileLists from "@/components/global/upload/file/FileLists";
export default {
    name: "UploadedFiles",
    components: {FileLists}
}
</script>

<style scoped>

</style>
