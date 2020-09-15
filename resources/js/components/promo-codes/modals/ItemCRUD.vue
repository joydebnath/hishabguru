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
                <b-field label="Promo Code">
                    <b-input></b-input>
                </b-field>
                <b-field>
                    <b-field label="Type">
                        <b-select placeholder="Select a type" expanded>
                            <option
                                v-for="(option, index) in options"
                                :value="option"
                                :key="index"
                            >
                                {{ option }}
                            </option>
                        </b-select>
                    </b-field>
                </b-field>
                <b-field grouped>
                    <b-field label="Discount">
                        <b-input></b-input>
                    </b-field>
                    <b-field label="Usages Limit">
                        <b-input></b-input>
                    </b-field>
                </b-field>
                <b-field label="Start and End Date">
                    <b-datepicker
                        v-model="dates"
                        placeholder="Type or select a date..."
                        icon="calendar-today"
                        editable
                        range
                    />
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
    data() {
        return {
            dates: [],
            options: ["Fixed Price", "Percentage"]
        };
    },
    computed: {
        title() {
            return this.$props.action_type == "edit"
                ? "Edit Promo Code"
                : "Add new Promo Code";
        }
    }
};
</script>

<style></style>
