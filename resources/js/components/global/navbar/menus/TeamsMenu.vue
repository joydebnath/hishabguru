<template>
    <b-dropdown aria-role="list">
        <span
            class="navbar-item text-sm leading-6 px-3 py-2 font-medium focus:outline-none hover:no-underline"
            :class="[$props.active == 'teams' ? 'text-blue-400 rounded font-semibold hover:text-blue-600' : 'text-gray-600 hover:text-gray-900 focus:text-gray-900']"
            slot="trigger"
            role="button"
        >
            <span>Teams</span>
            <b-icon icon="menu-down mt-1"/>
        </span>
        <router-link to="/@/employees">
            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">
                <div class="flex flex-row">
                    <WorkBag custom_class="h-5 w-5"/>
                    <div class="flex flex-col pl-3">
                        <p class="text-sm leading-6 font-medium text-gray-900">Employees</p>
                        <p class="text-xs leading-5 text-gray-500">List of all of your employees</p>
                    </div>
                </div>
            </b-dropdown-item>
        </router-link>
<!--        <router-link to="/@/leave-management">-->
<!--            <b-dropdown-item class="py-2 focus:outline-none" aria-role="listitem">-->
<!--                Leave Management-->
<!--            </b-dropdown-item>-->
<!--        </router-link>-->
    </b-dropdown>
</template>

<script>
import WorkBag from "@/components/icons/WorkBag";
export default {
    name: "TeamsMenu",
    components: {WorkBag},
    props: {
        active: String
    },
}
</script>

<style scoped>

</style>
