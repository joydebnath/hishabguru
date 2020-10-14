<template>
    <div class="max-w-6xl m-auto w-full">
        <BusinessLogo :logo="logo"/>
        <BusinessDetails :fields="business_details"/>
        <ContactDetails :fields="contact_details"/>
        <OperationDetails :fields="operation_details"/>
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
        axios
            .get('/business-settings/' + this.tenant_id)
            .then(({data}) => {
                const {logo, business_details, contact_details, operation_details} = data.data;
                this.logo = logo;
                this.business_details = business_details;
                this.contact_details = contact_details;
                this.operation_details = operation_details;
            })
            .catch(err => {
                console.log(err)
            })
    },
    data() {
        return {
            logo: '',
            business_details: {},
            contact_details: {},
            operation_details: {},
        }
    }
}
</script>

<style scoped>

</style>
