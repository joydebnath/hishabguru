<template>
    <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
            <p class="modal-card-title">New Client</p>
            <button
                type="button"
                class="delete"
                @click="$emit('on-close')"/>
        </header>
        <section class="modal-card-body">
            <b-field label="Name">
                <b-input
                    v-model="input_name"
                    placeholder="Enter Client Name"
                    required>
                </b-input>
            </b-field>

            <b-field label="Mobile">
                <b-input
                    v-model="mobile"
                    placeholder="Enter Mobile Number"
                    required>
                </b-input>
            </b-field>
        </section>
        <footer class="modal-card-foot">
            <button class="button" type="button" @click="$emit('on-close')">Close</button>
            <button class="button is-primary" @click="$emit('on-add',{name: input_name, mobile: mobile})">Add</button>
        </footer>
    </div>
</template>

<script>
export default {
    name: "ClientAddNew",
    props: {
        name: String
    },
    data() {
        return {
            input_name: null,
            mobile: null
        }
    },
    watch: {
        name(value) {
            this.input_name = value
        }
    }
}
</script>

<style scoped>

</style>
