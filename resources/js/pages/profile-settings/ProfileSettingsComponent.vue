<template>
    <div class="max-w-6xl m-auto w-full">
        <PersonalDetails :fields="personal_details" @on-update="handleUpdatePersonal"/>
        <ContactSetting :fields="contact_details" @on-update="handleUpdateContact"/>
        <PasswordSetting/>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';

import PersonalDetails from "./PersonalDetails";
import ContactSetting from "./ContactSetting";
import PasswordSetting from "./PasswordSetting";

export default {
    name: "ProfileSettingsComponent",
    components: {PasswordSetting, ContactSetting, PersonalDetails},
    data() {
        return {
            contact_details: null,
            personal_details: null
        }
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant'
        })
    },
    mounted() {
        axios
            .get('/profile-settings/' + this.tenant_id)
            .then(({data}) => {
                const {contact_details, personal_details} = data.data;
                this.contact_details = contact_details;
                this.personal_details = personal_details;
            })
            .catch(err => {
                console.log(err)
            })
    },
    methods: {
        handleUpdatePersonal(data) {
            this.personal_details = data.personal_details;
            this.$store.commit('setUser', {user: data.user})
        },
        handleUpdateContact(data) {
            this.contact_details = data
        }
    }
}
</script>
