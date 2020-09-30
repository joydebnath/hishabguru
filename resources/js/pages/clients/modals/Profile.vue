<template>
    <b-modal
        v-model="$props.show"
        :on-cancel="() => $emit('on-close')"
        :can-cancel="['x','escape']"
        full-screen
        has-modal-card
        trap-focus
        aria-role="dialog"
        aria-modal
    >
        <b-loading :is-full-page="false" v-model="$props.loading" :can-cancel="false"/>
        <div class="modal-card" >
            <header class="modal-card-head py-4 flex flex-row justify-between">
                <p class="text-lg text-gray-700" v-text="title"></p>
                <b-button type="is-dark is-large" class="h-4 w-4 p-4" rounded icon-left="close" @click="$emit('on-close')"></b-button>
            </header>
            <section class="modal-card-body">

            </section>
        </div>
    </b-modal>
</template>

<script>
export default {
    name: "Profile",
    props: {
        show: Boolean,
        loading: Boolean
    },
    computed:{
        title(){
            return 'Customer Name'
        }
    }
}
</script>

<style scoped>

</style>
