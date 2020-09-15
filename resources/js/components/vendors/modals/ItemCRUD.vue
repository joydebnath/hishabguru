<template>
    <b-modal
        v-model="$props.show"
        :on-cancel="() => $emit('on-close')"

        has-modal-card
        trap-focus
        aria-role="dialog"
        aria-modal
    >
        <b-loading :is-full-page="false" v-model="$props.loading" :can-cancel="false" />

        <div class="modal-card" style="width: 630px">
            <header class="modal-card-head flex flex-row justify-between">
                <p class="text-lg text-gray-700" v-text="title"></p>
                <button type="button" class="delete" @click="$emit('on-close')" />
            </header>
            <section class="modal-card-body">
                <b-field label="Company Name">
                    <b-input></b-input>
                </b-field>
                <b-field grouped>
                    <b-field label="Mobile">
                        <b-input></b-input>
                    </b-field>
                    <b-field label="Phone">
                        <b-input></b-input>
                    </b-field>
                </b-field>
                <b-field label="Emaill address">
                    <b-input></b-input>
                </b-field>
                <p class="font-semibold my-3">Contact address</p>
                <b-field>
                    <b-input placeholder="Address line 1"> </b-input>
                </b-field>

                <b-field>
                    <b-input placeholder="Address line 2"> </b-input>
                </b-field>
                <b-field grouped>
                    <b-field>
                        <b-input placeholder="City/Town"></b-input>
                    </b-field>
                    <b-field>
                        <b-input placeholder="Postal/Zip Code"></b-input>
                    </b-field>
                </b-field>
                <b-field grouped>
                    <b-field>
                        <b-input placeholder="Division"></b-input>
                    </b-field>
                    <b-field>
                        <b-input
                            placeholder="Country"
                            value="Bangladesh"
                        ></b-input>
                    </b-field>
                </b-field>
                <p class="font-semibold my-3">Primary contact person</p>
                <b-field>
                    <b-input placeholder="Full Name"></b-input>
                </b-field>
                <b-field grouped>
                    <b-field>
                        <b-input placeholder="Mobile"></b-input>
                    </b-field>
                    <b-field>
                        <b-input placeholder="Phone"></b-input>
                    </b-field>
                </b-field>
                <b-field>
                    <b-input placeholder="Emaill address"></b-input>
                </b-field>
                <b-field label="Note">
                    <b-input type="textarea"></b-input>
                </b-field>
            </section>
            <footer class="modal-card-foot flex justify-content-end">
                <button class="button is-primary">Save</button>
            </footer>
        </div>
    </b-modal>
</template>

<script>
export default {
    props: {
        show: Boolean,
        action_type: String,
        item: Object | Array,
        loading: Boolean
    },
    computed: {
        title() {
            return this.$props.action_type == "edit"
                ? "Edit Supplier"
                : "Add new Supplier";
        }
    }
};
</script>

<style></style>
