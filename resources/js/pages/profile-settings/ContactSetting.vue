<template>
    <ActionForm action_name="Contact Details" action_description="Keep your contact details updated">
        <div class="grid grid-cols-5 mb-4">
            <div class="col-span-3">
                <label class="label text-gray-700">Postal address</label>
                <b-field label="Address line 1" custom-class="text-sm">
                    <b-input custom-class="text-sm" v-model="computed_fields.address.address_line_1" required></b-input>
                </b-field>
                <b-field label="Address line 2" custom-class="text-sm">
                    <b-input custom-class="text-sm" v-model="computed_fields.address.address_line_2"></b-input>
                </b-field>
                <b-field grouped>
                    <b-field label="City" custom-class="text-sm">
                        <b-input custom-class="text-sm" v-model="computed_fields.address.city" required></b-input>
                    </b-field>
                    <b-field label="Postal Code" custom-class="text-sm">
                        <b-input custom-class="text-sm" v-model="computed_fields.address.postcode" required></b-input>
                    </b-field>
                </b-field>
                <b-field grouped>
                    <b-field label="State/Division" custom-class="text-sm">
                        <b-input custom-class="text-sm" v-model="computed_fields.address.state" required></b-input>
                    </b-field>
                    <b-field label="Country" custom-class="text-sm">
                        <b-input custom-class="text-sm" v-model="computed_fields.address.country" required></b-input>
                    </b-field>
                </b-field>
            </div>
        </div>
        <div class="grid grid-cols-5 border-b mb-4"></div>
        <div class="grid grid-cols-5">
            <div class="col-span-3">
                <b-field label="Phone Number" custom-class="text-sm">
                    <b-input custom-class="text-sm" v-model="computed_fields.phone"></b-input>
                </b-field>
            </div>
        </div>
        <template #footer>
            <b-button :loading="loading" type="is-info" class="text-sm rounded tracking-wider font-medium"
                      @click="handleUpdate">
                Update
            </b-button>
        </template>
    </ActionForm>
</template>

<script>
import {mapGetters} from "vuex";
import ActionForm from "@/components/global/form/ActionForm";

export default {
    name: "ContactSetting",
    components: {ActionForm},
    props: {
        fields: Object | Array
    },
    data() {
        return {
            items: {
                address: {},
                phone: null
            },
            loading: false
        }
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant'
        }),
        computed_fields() {
            if (this.$props.fields) {
                this.items = {...this.$props.fields}
            }
            return this.items
        }
    },
    methods: {
        handleUpdate() {
            this.loading = true;
            console.log({...this.computed_fields})
            axios
                .patch('/profile-settings/' + this.tenant_id, {
                    ...this.computed_fields,
                    address: {...this.computed_fields.address},
                    type: 'contact-details'
                })
                .then(({data}) => {
                    this.$emit('on-update', data.data);
                    this.loading = false;
                })
                .catch(err => {
                    console.log(err)
                    this.loading = false;
                })
        }
    }
}
</script>

<style scoped>

</style>
