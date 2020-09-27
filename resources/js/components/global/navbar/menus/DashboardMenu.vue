<template>
    <router-link to="/@/dashboard">
        <div class="text-sm leading-6 px-3 py-2 font-medium focus:outline-none hover:no-underline"
             :class="[$props.active == 'dashboard' ? 'text-blue-400 rounded font-semibold hover:text-blue-600' : 'text-gray-600 hover:text-gray-900 focus:text-gray-900']"
        >
            Dashboard
        </div>
    </router-link>
</template>

<script>
export default {
    name: "DashboardMenu",
    props: {
        active: String
    },
}
</script>
