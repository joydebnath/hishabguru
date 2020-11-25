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
                <p class="text-lg text-gray-700">Assign Role to Employee</p>
                <button type="button" class="delete" @click="$emit('on-close')"></button>
            </header>
            <section class="modal-card-body pb-0">
                <b-field
                    label="Email address"
                    custom-class="text-sm"
                    :type="computed_errors.email ? 'is-danger' : null"
                    :message="computed_errors.email ? computed_errors.email[0] : null"
                >
                    <b-input type="email" v-model="computed_item.email"></b-input>
                </b-field>
                <div class="grid grid-cols-7 gap-1 mt-4 border-t pt-4 bg-gray-100 bg-opacity-25 -mx-4 px-4 pb-4">
                    <div class="col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-sm font-medium text-gray-900">
                                Roles
                            </h3>
                        </div>
                    </div>
                    <div class="col-span-6">
                        <p class="help is-danger mb-2 -mt-1"
                           v-if="computed_errors.system_role"
                        >
                            {{ computed_errors.system_role[0] }}
                        </p>
                        <div class="flex flex-row bg-white shadow px-4 py-2 rounded-md mb-4">
                            <div class="grid grid-cols-9 gap-4">
                                <div class="col-span-1 pt-1">
                                    <b-radio
                                        name="system_role"
                                        v-model="computed_item.system_role"
                                        native-value="admin"
                                        type="is-dark"
                                    />
                                </div>
                                <div class="col-span-7">
                                    <p class="mb-1 text-gray-900 font-medium">System Admin</p>
                                    <p class="text-gray-600 text-sm">
                                        System admins have full create, read and edit access to everything in the
                                        business.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row bg-white shadow px-4 py-2 rounded-md mb-4">
                            <div class="grid grid-cols-9 gap-4">
                                <div class="col-span-1 pt-1">
                                    <b-radio
                                        name="system_role"
                                        v-model="computed_item.system_role"
                                        native-value="lead-sales"
                                        type="is-dark"
                                    />
                                </div>
                                <div class="col-span-7">
                                    <p class="mb-1 text-gray-900 font-medium">Lead Sales Person</p>
                                    <p class="text-gray-600 text-sm">
                                        Lead sales person have full create, read and edit access to sales in the
                                        business.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row bg-white shadow px-4 py-2 rounded-md">
                            <div class="grid grid-cols-9 gap-4">
                                <div class="col-span-1 pt-1">
                                    <b-radio
                                        name="system_role"
                                        v-model="computed_item.system_role"
                                        native-value="sales"
                                        type="is-dark"
                                    />
                                </div>
                                <div class="col-span-7">
                                    <p class="mb-1 text-gray-900 font-medium">Sales Person</p>
                                    <p class="text-gray-600 text-sm">
                                        Sales person have only create, and read access to sales in the
                                        business.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot flex justify-content-end px-4 py-2">
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
        item: Object | Array,
        loading: Boolean
    },
    data() {
        return {
            employee: {
                email: '',
                system_role: '',
            },
            errors: {
                email: null,
                system_role: null,
            }
        }
    },
    methods: {
        loading_event(value) {
            this.$emit('on-loading', value)
        },
        handleSave() {
            if (this.computed_item.email && this.computed_item.system_role) {
                this.createOrUpdate()
                return 0
            }
            this.validate();
        },
        validate() {
            if (!this.computed_item.email) {
                this.errors.email = ['Please fill this field']
            } else {
                this.errors.email = null
            }
            if (!this.computed_item.system_role) {
                this.errors.system_role = ['Please select a role']
            } else {
                this.errors.system_role = null
            }
        },
        createOrUpdate() {
            axios
                .patch(`/employees/${this.computed_item.id}/assign-role`, {
                    email: this.computed_item.email,
                    system_role: this.computed_item.system_role,
                })
                .then(({data}) => {
                    this.$emit('on-close')
                    this.$emit('on-update')
                    this.resetForm()
                })
                .catch(err => {
                    if(err.request && err.request.status === 422){
                        const res = JSON.parse(err.request.response);
                        this.errors = res.errors
                    }
                })
        },
        resetForm() {
            this.employee = {
                email: '',
                system_role: '',
            }
        },
        resetErrors() {
            this.errors = {
                email: '',
                system_role: '',
            }
        }
    },
    computed: {
        ...mapGetters({
            current_tenant_id: 'tenancy/getCurrentTenant'
        }),
        computed_item() {
            if (this.$props.item) {
                this.employee = this.$props.item;
            }
            return {...this.employee, tenant_id: this.current_tenant_id}
        },
        computed_errors() {
            return {...this.errors}
        }
    }
};
</script>

<style></style>
