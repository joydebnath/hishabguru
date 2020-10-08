<template>
    <b-modal
        v-model="$props.show"
        :on-cancel="() => $emit('on-close')"
        :can-cancel="['x','escape']"
        has-modal-card
        trap-focus
        aria-role="dialog"
        aria-modal
    >
        <b-loading :is-full-page="false" v-model="$props.loading" :can-cancel="false"/>
        <div class="modal-card" style="width: 630px">
            <header class="modal-card-head flex flex-row justify-between">
                <p class="text-lg text-gray-700" v-text="title"></p>
                <button type="button" class="delete" @click="$emit('on-close')"></button>
            </header>
            <section class="modal-card-body">
                <b-field label="Full Name" custom-class="text-sm">
                    <b-input v-model="computed_item.name"></b-input>
                </b-field>
                <b-field grouped>
                    <b-field label="Mobile" custom-class="text-sm">
                        <b-input v-model="computed_item.mobile"></b-input>
                    </b-field>
                    <b-field label="Phone" custom-class="text-sm">
                        <b-input v-model="computed_item.phone"></b-input>
                    </b-field>
                </b-field>

                <b-field grouped>
                    <b-field label="Email address" custom-class="text-sm">
                        <b-input v-model="computed_item.email"></b-input>
                    </b-field>
                    <b-field label="Employee ID" custom-class="text-sm">
                        <b-input v-model="computed_item.employee_id"></b-input>
                    </b-field>
                </b-field>

                <b-field grouped>
                    <b-field label="Job Title" custom-class="text-sm">
                        <b-input v-model="computed_item.job_title"></b-input>
                    </b-field>
                    <b-field label="Currently Working?" custom-class="text-sm">
                        <b-switch
                            class="mt-2 ml-2"
                            v-model="currently_working"
                            :true-value="1"
                            :false-value="0"
                        >
                            <span v-if="currently_working">Yes</span>
                            <span v-else>No</span>
                        </b-switch>
                    </b-field>
                </b-field>

                <p class="font-semibold mt-4 my-3 ">
                    <span class="mr-2">Contact address <b-tag>Home</b-tag></span>
                </p>
                <b-field>
                    <b-input placeholder="Address line 1" v-model="computed_item.address_line_1"></b-input>
                </b-field>

                <b-field>
                    <b-input placeholder="Address line 2" v-model="computed_item.address_line_2"></b-input>
                </b-field>
                <b-field grouped>
                    <b-field>
                        <b-input placeholder="City/Town" v-model="computed_item.city"></b-input>
                    </b-field>
                    <b-field>
                        <b-input placeholder="Postal/Zip Code" v-model="computed_item.postcode"></b-input>
                    </b-field>
                </b-field>
                <b-field grouped>
                    <b-field>
                        <b-input placeholder="Division" v-model="computed_item.state"></b-input>
                    </b-field>
                    <b-field>
                        <b-input placeholder="Country" value="Bangladesh" v-model="computed_item.country"></b-input>
                    </b-field>
                </b-field>
                <b-field label="Note" custom-class="text-sm">
                    <b-input type="textarea" v-model="computed_item.note"></b-input>
                </b-field>
            </section>
            <footer class="modal-card-foot flex justify-content-end">
                <button class="button is-primary" @click="handleSave">Save</button>
            </footer>
        </div>
    </b-modal>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    props: {
        show: Boolean,
        action_type: String,
        item: Object | Array,
        loading: Boolean
    },
    data() {
        return {
            employee: {
                id: '',
                name: '',
                mobile: '',
                phone: '',
                email: '',
                employee_id: '',
                job_title: '',
                address_line_1: '',
                address_line_2: '',
                city: '',
                postcode: '',
                state: '',
                country: '',
                note: '',
            },
            currently_working: 1,
        }
    },
    methods: {
        loading_event(value) {
            this.$emit('on-loading', value)
        },
        handleSave() {
            if (this.$props.action_type == "edit") {
                this.update();
                return 0;
            }
            this.create()
        },
        update() {
            this.loading_event(true);
            axios
                .put('/employees/' + this.computed_item.id, {
                    ...this.computed_item,
                    currently_working: this.currently_working
                })
                .then(({data}) => {
                    this.loading_event(false);
                    this.$store.commit('employees/update', {employee: data.data})
                    this.employee = data.data
                    this.$emit('on-close')
                    this.$buefy.notification.open({
                        message: 'Employee has been updated',
                        type: 'is-success is-light',
                        duration: 5000
                    })
                })
                .catch(err => {
                    this.loading_event(false);
                    this.$buefy.notification.open({
                        message: 'Employee update failed',
                        type: 'is-danger is-light',
                        duration: 5000
                    })
                })
        },
        create() {
            this.loading_event(true);
            axios
                .post('/employees', {
                    ...this.computed_item,
                    currently_working: this.currently_working,
                    address_type: 'home'
                })
                .then(({data}) => {
                    this.loading_event(false);
                    this.employee = {};
                    this.$emit('on-close');
                    this.$buefy.notification.open({
                        message: 'Employee is created',
                        type: 'is-success is-light',
                        duration: 5000
                    })
                    if (this.total < this.per_page) {
                        this.$store.dispatch('employees/loadData', {page: 1})
                    }
                })
                .catch(err => {
                    this.loading_event(false);
                    this.$buefy.notification.open({
                        message: 'Whoops! Something went wrong...',
                        type: 'is-danger is-light',
                        duration: 5000
                    })
                })
        }
    },
    computed: {
        ...mapGetters({
            total: 'employees/getTotal',
            per_page: 'getPerPage',
            current_tenant_id: 'tenancy/getCurrentTenant'
        }),
        title() {
            return this.$props.action_type == "edit"
                ? "Edit Employee"
                : "Add new Employee";
        },
        computed_item() {
            if (this.$props.item) {
                this.employee = this.$props.item;
                this.is_working = this.$props.item.currently_working
            }
            return {...this.employee, tenant_id: this.current_tenant_id}
        }
    }
};
</script>

<style></style>
