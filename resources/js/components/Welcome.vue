<template>
    <div class="container">
        <div class="flex flex-col w-full ">
            <TopNavbar :logo="$props.logo"/>
            <router-view/>
            <footer class="footer py-4 bg-gray-100">
                <p class="text-center text-gray-700 text-xs tracking-widest">
                    © {{ read_year }} HishabGuru.com.
                    <span class="uppercase">All Rights Reserved</span>.
                </p>
            </footer>
        </div>
    </div>
</template>

<script>
import TopNavbar from "./landing/TopNav";

export default {
    components: {
        TopNavbar
    },
    name: "App",
    props: {
        logo: String,
        welcome_banner: String,
        svg_1: String,
        svg_2: String,
        svg_3: String,
        svg_4: String,
        svg_5: String,
        svg_6: String,
        svg_7: String,
    },
    computed: {
        read_year() {
            return new Date().getFullYear();
        }
    },
    mounted() {
        this.$store.commit('setWelcomeBanner', {value: this.$props.welcome_banner})
        this.$store.commit('setSvg1', {value: this.$props.svg_1})
        this.$store.commit('setSvg2', {value: this.$props.svg_2})
        this.$store.commit('setSvg3', {value: this.$props.svg_3})
        this.$store.commit('setSvg4', {value: this.$props.svg_4})
        this.$store.commit('setSvg5', {value: this.$props.svg_5})
        this.$store.commit('setSvg6', {value: this.$props.svg_6})
        this.$store.commit('setSvg7', {value: this.$props.svg_7})
    }
}
</script>


<style>
.container {
    max-width: 100%;
    min-height: 100vh;
    display: flex;
}

.noto {
    font-family: "Noto Sans", sans-serif;
}

.poppins {
    font-family: "Poppins", sans-serif;
}

.robo {
    font-family: "Roboto", sans-serif;
}

.footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
}
</style>
