<template>
    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm leading-5">
        <div class="w-0 flex-1 flex items-center">
            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                      clip-rule="evenodd"/>
            </svg>
            <span class="ml-2 flex-1 w-0 truncate">
                <b-progress size="is-small" v-if="$props.uploading"></b-progress>
                <span v-else>{{$props.name}}</span>
            </span>
        </div>
        <div class="ml-4 flex-shrink-0" v-if="!$props.uploading">
            <b-tooltip
                label="Download"
                type="is-dark"
                size="is-small"
            >
                <b-icon pack="fas" custom-class="text-gray-600" icon="file-download"/>
            </b-tooltip>
            <b-tooltip
                label="Delete"
                type="is-dark"
                size="is-small"
            >
                <b-icon pack="far" custom-class="text-red-700" icon="trash-alt"/>
            </b-tooltip>
        </div>
    </li>
</template>

<script>
export default {
    name: "File",
    props:{
        name: String,
        uploading: {
            type: Boolean,
            default: false
        },
        upload_progress: Number
    }
}
</script>

<style scoped>

</style>
