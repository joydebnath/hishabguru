<template>
    <div class="max-w-6xl m-auto w-full">
        <BusinessDetails></BusinessDetails>
        <ContactDetails></ContactDetails>
        <OperationDetails></OperationDetails>
    </div>
</template>

<script>

import BusinessDetails from "./BusinessDetails";
import ContactDetails from "./ContactDetails";
import OperationDetails from "./OperationDetails";

export default {
    name: "BusinessSettingComponent",
    components: {BusinessDetails, ContactDetails, OperationDetails}
}
</script>

<style scoped>

</style>
