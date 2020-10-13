<template>
    <div class="max-w-6xl m-auto w-full">
        <BusinessLogo></BusinessLogo>
        <BusinessDetails></BusinessDetails>
        <ContactDetails></ContactDetails>
        <OperationDetails></OperationDetails>
    </div>
</template>

<script>

import BusinessDetails from "./BusinessDetails";
import ContactDetails from "./ContactDetails";
import OperationDetails from "./OperationDetails";
import BusinessLogo from "./BusinessLogo";

export default {
    name: "BusinessSettingComponent",
    components: {BusinessLogo, BusinessDetails, ContactDetails, OperationDetails}
}
</script>

<style scoped>

</style>
