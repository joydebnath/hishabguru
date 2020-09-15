<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand flex flex-row items-center p-0">
                <img src="/images/2.png" alt="logo" class="d-inline" style="width: 110px">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <UserMenu :username="username"/>
        </div>
    </nav>
</template>

<script>
import UserMenu from './UserMenu'
export default {
    name: "TopNavbar",
    components:{
        UserMenu
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
