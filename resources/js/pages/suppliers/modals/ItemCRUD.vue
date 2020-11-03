<template>
    <b-modal
        v-model="$props.show"
        :on-cancel="handleCloseModal"
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
                <button type="button" class="delete" @click="handleCloseModal"/>
            </header>
            <section class="modal-card-body">
                <b-field
                    label="Company Name"
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
                        <b-input v-model="computed_item.phone"></b-input>
                    </b-field>
                </b-field>
                <b-field label="Email address">
                    <b-input v-model="computed_item.email"></b-input>
                </b-field>
                <p class="font-semibold mt-4 mb-3 ">
                    <span class="mr-2">Contact address <b-tag>Headquarter</b-tag></span>
                </p>
                <b-field
                    :type="computed_errors.address_line_1 ? 'is-danger' :null"
                    :message="computed_errors.address_line_1 ? 'This field is required' : null"
                >
                    <b-input
                        custom-class="pr-0"
                        v-model="computed_item.address_line_1"
                        placeholder="Address line 1"
                    />
                </b-field>

                <b-field>
                    <b-input v-model="computed_item.address_line_2" placeholder="Address line 2"></b-input>
                </b-field>
                <b-field grouped>
                    <b-field
                        :type="computed_errors.city ? 'is-danger' :null"
                        :message="computed_errors.city ? 'This field is required' : null"
                    >
                        <b-input custom-class="pr-0" v-model="computed_item.city" placeholder="City"/>
                    </b-field>
                    <b-field
                        :type="computed_errors.postcode ? 'is-danger' :null"
                        :message="computed_errors.postcode ? 'This field is required' : null"
                    >
                        <b-input custom-class="pr-0" v-model="computed_item.postcode" placeholder="Postal Code"/>
                    </b-field>
                </b-field>
                <b-field grouped>
                    <b-field
                        :type="computed_errors.state ? 'is-danger' :null"
                        :message="computed_errors.state ? 'This field is required' : null"
                    >
                        <b-input
                            custom-class="pr-0"
                            v-model="computed_item.state"
                            placeholder="State/Division"
                        />
                    </b-field>
                    <b-field
                        :type="computed_errors.country ? 'is-danger' :null"
                        :message="computed_errors.country ? 'This field is required' : null"
                    >
                        <b-input
                            custom-class="pr-0"
                            v-model="computed_item.country"
                            placeholder="Country"
                        />
                    </b-field>
                </b-field>
                <p class="font-semibold mt-4 mb-3">
                    <b-checkbox v-model="computed_primary_contact_checkbox">Primary contact person</b-checkbox>
                </p>
                <template v-if="enable_primary_contact">
                    <b-field
                        :type="computed_errors.primary_contact_person_name ? 'is-danger' :null"
                        :message="computed_errors.primary_contact_person_name ? 'This field is required' : null"
                    >
                        <b-input
                            custom-class="pr-0"
                            v-model="computed_item.primary_contact_person_name"
                            placeholder="Full Name"
                        />
                    </b-field>
                    <b-input v-model="computed_item.primary_contact_person_id" hidden></b-input>
                    <b-field>
                        <b-input
                            v-model="computed_item.primary_contact_person_email"
                            placeholder="Email address"
                        />
                    </b-field>
                    <b-field grouped>
                        <b-field
                            :type="computed_errors.primary_contact_person_mobile ? 'is-danger' :null"
                            :message="computed_errors.primary_contact_person_mobile ? 'This field is required' : null"
                        >
                            <b-input
                                custom-class="pr-0"
                                v-model="computed_item.primary_contact_person_mobile"
                                placeholder="Mobile"
                            />
                        </b-field>
                        <b-field>
                            <b-input
                                custom-class="pr-0"
                                v-model="computed_item.primary_contact_person_phone"
                                placeholder="Phone"
                            />
                        </b-field>
                    </b-field>
                </template>
                <b-field label="Note">
                    <b-input v-model="computed_item.note" type="textarea"></b-input>
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
            enable_primary_contact: false,
            supplier: {
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
                primary_contact_person_name: '',
                primary_contact_person_mobile: '',
                primary_contact_person_phone: '',
                primary_contact_person_email: '',
                primary_contact_person_id: '',
            },
            errors: {}
        }
    },
    methods: {
        loading_event(value) {
            this.$emit('on-loading', value)
        },
        handleCloseModal() {
            this.$emit('on-close');
            this.enable_primary_contact = false;
        },
        validate() {
            let error_bag = {}

            for (let value in this.computed_item) {
                if (this.computed_required_field[value] && _.isEmpty(this.computed_item[value])) {
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
        getRequestParams() {
            return {
                ...this.computed_item,
                address_type: 'headquarter',
                has_primary_contact: this.enable_primary_contact
            };
        },
        update() {
            this.loading_event(true);
            axios
                .put('/suppliers/' + this.computed_item.id, this.getRequestParams())
                .then(({data}) => {
                    this.loading_event(false);
                    this.$store.commit('suppliers/update', {supplier: data.data})
                    this.supplier = data.data
                    this.$emit('on-close')
                    this.onSuccess('Supplier has been updated')
                })
                .catch(err => {
                    console.log(err)
                    this.loading_event(false);
                    this.onError('Supplier update failed')
                })
        },
        create() {
            this.loading_event(true);
            axios
                .post('/suppliers', this.getRequestParams())
                .then(({data}) => {
                    this.loading_event(false);
                    this.supplier = {};
                    this.$emit('on-close');
                    this.onSuccess('Supplier is created')
                    if (this.total < this.per_page) {
                        this.$store.dispatch('suppliers/loadData', {page: 1})
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
            total: 'suppliers/getTotal',
            per_page: 'getPerPage',
            tenant_id: 'tenancy/getCurrentTenant'
        }),
        title() {
            return this.$props.action_type == "edit"
                ? "Edit Supplier"
                : "Add new Supplier";
        },
        computed_item() {
            if (!_.isEmpty(this.$props.item)) {
                this.supplier = this.$props.item;
            }
            return {...this.supplier, tenant_id: this.tenant_id}
        },
        computed_errors() {
            return this.errors
        },
        computed_required_field() {
            let fields = {
                name: true,
                mobile: true,
                address_line_1: true,
                city: true,
                postcode: true,
                state: true,
                country: true,
            }

            if (this.enable_primary_contact) {
                fields = {
                    ...fields,
                    primary_contact_person_name: true,
                    primary_contact_person_mobile: true
                }
            }

            return fields
        },
        computed_primary_contact_checkbox: {
            get() {
                if (this.$props.item.primary_contact_person_name) {
                    this.enable_primary_contact = true;
                }
                return this.enable_primary_contact
            },
            set(value) {
                this.enable_primary_contact = value
            }
        }
    }
};
</script>

<style></style>
