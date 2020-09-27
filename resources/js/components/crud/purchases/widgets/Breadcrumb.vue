<template>
    <nav class="breadcrumb flex-row-reverse bg-white shadow-sm text-sm align-items-center" aria-label="breadcrumbs">
        <ul>
            <li><span class="text-blue-400 px-2">Business</span></li>
            <li>
                <router-link to="/@/purchases"><span class="text-blue-400 ">Purchases</span></router-link>
            </li>
            <li class="is-active"><a href="#" aria-current="page">{{ $props.active_link_name }}</a></li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: "Breadcrumb",
    props: {
        active_link_name: String
    }
}
</script>

<style scoped>

</style>
