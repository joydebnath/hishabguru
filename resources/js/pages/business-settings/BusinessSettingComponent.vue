<template>
    <div class="max-w-6xl m-auto w-full">
        <b-loading :is-full-page="true" v-model="loading" :can-cancel="false"></b-loading>
        <BusinessLogo :logo="logo" :loading="loading" @on-update="handleUpdateLogo" @on-loading="handleLoading"/>
        <BusinessDetails :fields="business_details" @on-update="handleBusinessDetails"/>
        <ContactDetails :fields="contact_details" @on-update="handleContactDetails"/>
        <OperationDetails :fields="operation_details" @on-update="handleOperationDetails"/>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import BusinessDetails from "./BusinessDetails";
import ContactDetails from "./ContactDetails";
import OperationDetails from "./OperationDetails";
import BusinessLogo from "./BusinessLogo";

export default {
    name: "BusinessSettingComponent",
    components: {BusinessLogo, BusinessDetails, ContactDetails, OperationDetails},
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant'
        }),
    },
    mounted() {
        if (this.tenant_id) {
            this.loading = true;
            axios
                .get('/business-settings/' + this.tenant_id)
                .then(({data}) => {
                    const {logo, business_details, contact_details, operation_details} = data.data;
                    this.logo = logo;
                    this.business_details = business_details;
                    this.contact_details = contact_details;
                    this.operation_details = operation_details;
                    this.loading = false;
                })
                .catch(err => {
                    console.log(err)
                    this.loading = false;
                })
        }
    },
    data() {
        return {
            logo: '',
            business_details: {},
            contact_details: {},
            operation_details: {},
            loading: false
        }
    },
    methods: {
        handleUpdateLogo(data) {
            this.logo = data;
        },
        handleBusinessDetails(data) {
            this.business_details = data;
        },
        handleContactDetails(data) {
            this.contact_details = data;
        },
        handleOperationDetails(data) {
            this.operation_details = data;
        },
        handleLoading(value) {
            this.loading = value
        }
    }
}
</script>

<style scoped>

</style>
