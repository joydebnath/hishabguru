<template>
    <b-modal
        v-model="$props.show"
        has-modal-card
        trap-focus
        aria-role="dialog"
        aria-modal
    >
        <div class="modal-card" style="width: 630px">
            <header class="modal-card-head flex flex-row justify-between">
                <p class="text-lg text-gray-700" v-text="title"></p>
                <button type="button" class="delete" @click="$emit('close')" />
            </header>
            <section class="modal-card-body">
                <b-field label="Item Name" custom-class="w-3/5">
                    <b-input></b-input>
                </b-field>
                <b-field grouped>
                    <b-field label="Item Code" custom-class="w2/5">
                        <b-input></b-input>
                    </b-field>
                    <b-field label="Type">
                        <b-input></b-input>
                    </b-field>
                </b-field>
                <b-field grouped>
                    <b-field label="Buying Unit Cost">
                        <b-input></b-input>
                    </b-field>
                    <b-field label="Quantity">
                        <b-input></b-input>
                    </b-field>
                </b-field>
                <b-field grouped>
                    <b-field label="Selling Unit Price">
                        <b-input></b-input>
                    </b-field>
                    <b-field label="Tax rate">
                        <b-input></b-input>
                    </b-field>
                </b-field>
                <b-field label="Description">
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
        action_type: String
    },
    computed: {
        title() {
            return this.$props.action_type == "edit"
                ? "Edit Product"
                : "Add new Product";
        }
    }
};
</script>

<style></style>
