<template>
    <div class="grid grid-cols-3 gap-2 border-b py-2 px-4">
        <div class="col-span-2">
            <p class="text-sm tracking-wider mb-0">{{top_left}}</p>
            <a :href="$props.url" target="_blank" class="tracking-wide text-xs mb-0">{{bottom_left}}</a>
        </div>
        <div class="col-span-1">
            <p class="text-sm text-right mb-0" :class="top_right_color">
                {{ top_right }}
            </p>
            <p class="text-right text-xs mb-0 tracking-wider text-uppercase" :class="bottom_right_color">{{ bottom_right }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "RecordRow",
    props: {
        top_left: String,
        bottom_left: String,
        top_right: String,
        bottom_right: String,
        top_right_color: {
            type: String,
            default: 'text-indigo-600'
        },
        bottom_right_color: {
            type: String,
            default: 'text-teal-600'
        },
        url: {
            type: String,
            default: '#'
        },
    }
}
</script>

<style scoped>

</style>
