import Vue from 'vue'

import VueRouter from 'vue-router'
import Vuex from 'vuex'

Vue.use(Vuex)
Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'welcome',
            component: LandingComponent,
        },
        {
            path: '/pricing',
            name: 'pricing',
            component: PricingComponent,
        },
        {
            path: '/blog',
            name: 'welcome',
            component: ExampleComponent,
        },
    ]
})

const store = new Vuex.Store({
    state: {
        welcome_banner:'',
        svg_1: '',
        svg_2: '',
        svg_3: '',
        svg_4: '',
        svg_5: '',
        svg_6: '',
        svg_7: '',
    },
    getters: {
        getWelcomeBanner: state => state.welcome_banner,
        getSvg1: state => state.svg_1,
        getSvg2: state => state.svg_2,
        getSvg3: state => state.svg_3,
        getSvg4: state => state.svg_4,
        getSvg5: state => state.svg_5,
        getSvg6: state => state.svg_6,
        getSvg7: state => state.svg_7,

    },
    mutations: {
        setWelcomeBanner: (state, {value}) => state.welcome_banner = value,
        setSvg1: (state, {value}) => state.svg_1 = value,
        setSvg2: (state, {value}) => state.svg_2 = value,
        setSvg3: (state, {value}) => state.svg_3 = value,
        setSvg4: (state, {value}) => state.svg_4 = value,
        setSvg5: (state, {value}) => state.svg_5 = value,
        setSvg6: (state, {value}) => state.svg_6 = value,
        setSvg7: (state, {value}) => state.svg_7 = value,
    },
})


import App from './components/Welcome'
import ExampleComponent from "./components/ExampleComponent";
import LandingComponent from "./components/landing/LandingComponent";
import PricingComponent from "./components/landing/PricingComponent";

const app = new Vue({
    el: '#app',
    components: {app: App},
    router,
    store
});
