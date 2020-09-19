<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand flex flex-row items-center p-0">
                <img src="/images/logo.png" alt="logo" class="d-inline" style="width: 110px">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="flex flex-row items-center">
                <!--<AddNewItemMenu/>-->
                <UserMenu :username="username"/>
            </div>
        </div>
    </nav>
</template>

<script>
import UserMenu from './menus/UserMenu'
import AddNewItemMenu from './menus/AddNewItemMenu'

export default {
    name: "TopNavbar",
    components: {
        AddNewItemMenu, UserMenu
    },
    props: {
        username: {
            type: String,
            default: 'User'
        },
    },
    methods: {
        handleLogout() {

        }
    }
}
</script>

<style scoped>

</style>
