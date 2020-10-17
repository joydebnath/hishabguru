<template>
    <ActionForm action_name="Personal Details" action_description="Keep your personal details updated">
        <div class="grid grid-cols-5">
            <div class="col-span-3">
                <b-field label="Name" custom-class="text-sm">
                    <b-input custom-class="text-sm" v-model="computed_name"/>
                </b-field>
                <b-field label="Job Title" custom-class="text-sm">
                    <b-input custom-class="text-sm" v-model="computed_items.job_title"/>
                </b-field>
                <b-field label="Email Address" custom-class="text-sm">
                    <b-input type="email" custom-class="text-sm bg-white border" disabled :value="computed_email"/>
                </b-field>
            </div>
        </div>
        <template #footer>
            <b-button :loading="loading" type="is-info" class="text-sm rounded tracking-wider font-medium" @click="handleUpdate">
                Update
            </b-button>
        </template>
    </ActionForm>
</template>

<script>
import {mapGetters} from 'vuex';
import ActionForm from "@/components/global/form/ActionForm";

export default {
    name: "PersonalDetails",
    components: {ActionForm},
    props: {
        fields: Object | Array
    },
    data() {
        return {
            name: '',
            email: '',
            items: {},
            loading: false
        }
    },
    methods: {
        handleUpdate() {
            this.loading = true;
            axios
                .patch('/profile-settings/' + this.tenant_id, {
                    ...this.computed_items,
                    name: this.computed_name,
                    type: 'personal-details'
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
    },
    computed: {
        ...mapGetters({
            user: 'getUser',
            tenant_id: 'tenancy/getCurrentTenant'
        }),
        computed_name() {
            if (this.name) {
                return this.name;
            }
            this.name = this.user ? this.user.name : '';
            return this.name;
        },
        computed_email() {
            if (this.email) {
                return this.email;
            }
            this.email = this.user ? this.user.email : '';
            return this.email;
        },
        computed_items() {
            if (this.$props.fields) {
                this.items = {...this.$props.fields}
            }
            return this.items
        }
    }
}
</script>

<style scoped>

</style>
