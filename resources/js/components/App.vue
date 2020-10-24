<template>
    <div>
        <b-loading :is-full-page="true" v-model="loadingUser" :can-cancel="false"></b-loading>
        <template v-if="!loadingUser">
            <TopNavBar/>
            <TopMenuBar :active="active_page_type"/>
            <header class="max-w-6xl mx-auto pt-5" v-if="title">
                <h1 class="text-xl font-medium tracking-wider leading-tight px-2 text-gray-700 uppercase">
                    {{ title }}
                </h1>
            </header>
            <main class="py-4">
                <router-view/>
            </main>
        </template>
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
        logo: String
    },
    beforeMount() {
        this.setPageType({type: this.$route.meta.type})
        this.setTitle({title: this.$route.name})
        this.setLogo({url: this.$props.logo})
        this.$store.dispatch('init')
    },
    methods: {
        ...mapMutations({
            setTitle: 'setTitle',
            setLogo: 'setLogo',
            setPageType: 'setPageType',
            setUser: 'setUser',
        })
    },
    computed: {
        ...mapGetters({
            title: 'getTitle',
            active_page_type: 'getPageType',
            loadingUser: 'getLoadingUser'
        }),
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
