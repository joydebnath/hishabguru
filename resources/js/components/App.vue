<template>
    <div>
        <TopNavBar :username="username"/>
        <TopMenuBar :active="active_page_type"/>
        <header class="max-w-6xl mx-auto pt-5" v-if="title">
            <h1 class="text-xl font-medium tracking-wider leading-tight px-2 text-gray-700 uppercase">
                {{ title }}
            </h1>
        </header>
        <main class="py-4">
            <router-view />
        </main>
    </div>
</template>

<script>
import {mapGetters, mapMutations} from 'vuex';

import TopNavBar from "./global/navbar/TopNavBar";
import TopMenuBar from "./global/navbar/TopMenuBar";

export default {
    components: {
        TopMenuBar,
        TopNavBar
    },
    name: "App",
    props: {
        user: Object | Array
    },
    mounted() {
        this.setPageType({type: this.$route.meta.type})
        this.setTitle({title: this.$route.name})
    },
    methods: {
        ...mapMutations({
            setTitle: 'setTitle',
            setPageType: 'setPageType',
        })
    },
    computed: {
        ...mapGetters({
            title: 'getTitle',
            active_page_type: 'getPageType',
        }),
        username() {
            if (this.$props.user) {
                return this.$props.user.name
            }
            return ''
        },
    },
    watch: {
        $route(to, from) {
            this.setPageType({type: to.meta.type})
            this.setTitle({title: to.name})
        }
    }
}
</script>

<style scoped>

</style>
