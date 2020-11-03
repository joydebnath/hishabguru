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
                <b-field
                    label="Full Name"
                    :type="computed_errors.name ? 'is-danger' :null"
                    :message="computed_errors.name ? 'This field is required' : null"
                >
                    <b-input custom-class="pr-0" v-model="computed_item.name"></b-input>
                </b-field>
                <b-field grouped>
                    <b-field
                        label="Mobile"
                        :type="computed_errors.mobile ? 'is-danger' :null"
                        :message="computed_errors.mobile ? 'This field is required' : null"
                    >
                        <b-input custom-class="pr-0" v-model="computed_item.mobile"></b-input>
                    </b-field>
                    <b-field label="Phone">
                        <b-input custom-class="pr-0" v-model="computed_item.phone"></b-input>
                    </b-field>
                </b-field>
                <b-field label="Email address">
                    <b-input custom-class="pr-0" v-model="computed_item.email"></b-input>
                </b-field>
                <p class="font-semibold mt-4 my-3 ">
                    <span class="mr-2">Contact address <b-tag>Home</b-tag></span>
                </p>
                <b-field :type="computed_errors.address_line_1 ? 'is-danger' :null"
                         :message="computed_errors.address_line_1 ? 'This field is required' : null"
                >
                    <b-input
                        custom-class="pr-0"
                        placeholder="Address line 1"
                        v-model="computed_item.address_line_1"
                    />
                </b-field>

                <b-field>
                    <b-input custom-class="pr-0"
                             placeholder="Address line 2"
                             v-model="computed_item.address_line_2"
                    />
                </b-field>
                <b-field grouped>
                    <b-field
                        :type="computed_errors.city ? 'is-danger' :null"
                        :message="computed_errors.city ? 'This field is required' : null"
                    >
                        <b-input custom-class="pr-0" placeholder="City" v-model="computed_item.city" required></b-input>
                    </b-field>
                    <b-field
                        :type="computed_errors.postcode ? 'is-danger' :null"
                        :message="computed_errors.postcode ? 'This field is required' : null"
                    >
                        <b-input
                            custom-class="pr-0"
                            placeholder="Postal"
                            v-model="computed_item.postcode"
                        />
                    </b-field>
                </b-field>
                <b-field grouped>
                    <b-field
                        :type="computed_errors.state ? 'is-danger' :null"
                        :message="computed_errors.state ? 'This field is required' : null"
                    >
                        <b-input
                            custom-class="pr-0"
                            placeholder="State/Division"
                            v-model="computed_item.state"
                        />
                    </b-field>
                    <b-field
                        :type="computed_errors.country ? 'is-danger' :null"
                        :message="computed_errors.country ? 'This field is required' : null"
                    >
                        <b-input
                            custom-class="pr-0"
                            placeholder="Country"
                            v-model="computed_item.country"
                        />
                    </b-field>
                </b-field>
                <b-field label="Note">
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
            client: {
                id: '',
                name: '',
                mobile: '',
                phone: '',
                email: '',
                address_line_1: '',
                address_line_2: '',
                city: '',
                postcode: '',
                state: '',
                country: '',
                note: '',
            },
            required_fields: {
                name: true,
                mobile: true,
                address_line_1: true,
                city: true,
                postcode: true,
                state: true,
                country: true,
            },
            errors: {}
        }
    },
    methods: {
        loading_event(value) {
            this.$emit('on-loading', value)
        },
        validate() {
            let error_bag = {}

            for (let value in this.computed_item) {
                if (this.required_fields[value] && _.isEmpty(this.computed_item[value])) {
                    error_bag[value] = true
                }
            }
            this.errors = error_bag
        },
        handleSave() {
            this.validate()
            if (_.isEmpty(this.errors)) {
                if (this.$props.action_type == "edit") {
                    this.update();
                    return 0;
                }
                this.create()
            }
        },
        update() {
            this.loading_event(true);
            axios
                .put('/clients/' + this.computed_item.id, this.computed_item)
                .then(({data}) => {
                    this.loading_event(false);
                    this.$store.commit('clients/update', {client: data.data})
                    this.client = data.data
                    this.$emit('on-close')
                    this.onSuccess('Client has been updated')
                })
                .catch(err => {
                    this.loading_event(false);
                    this.onError('Client update failed')
                })
        },
        create() {
            this.loading_event(true);
            axios
                .post('/clients', {...this.computed_item, address_type: 'home'})
                .then(({data}) => {
                    this.loading_event(false);
                    this.client = {};
                    this.$emit('on-close');
                    this.onSuccess('Client is created')
                    if (this.total < this.per_page) {
                        this.$store.dispatch('clients/loadData', {page: 1})
                    }
                })
                .catch(err => {
                    this.loading_event(false);
                    this.onError()
                })
        },
        onSuccess(message) {
            this.$buefy.notification.open({
                message: message,
                type: 'is-success is-light',
                duration: 5000
            })
        },
        onError(message = 'Whoops! Something went wrong...') {
            this.$buefy.notification.open({
                message: message,
                type: 'is-danger is-light',
                duration: 5000
            })
        }
    },
    computed: {
        ...mapGetters({
            total: 'clients/getTotal',
            per_page: 'getPerPage',
            tenant_id: 'tenancy/getCurrentTenant'
        }),
        title() {
            return this.$props.action_type == "edit"
                ? "Edit Client"
                : "Add new Client";
        },
        computed_item() {
            if (!_.isEmpty(this.$props.item)) {
                this.client = this.$props.item;
            }
            return {...this.client, tenant_id: this.tenant_id}
        },
        computed_errors() {
            return this.errors
        }
    }
};
</script>

<style></style>
