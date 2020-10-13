<template>
    <div class="max-w-6xl m-auto w-full">
        <PersonalDetails/>
        <ContactSetting/>
        <PasswordSetting/>
    </div>
</template>

<script>
import PersonalDetails from "./PersonalDetails";
import ContactSetting from "./ContactSetting";
import PasswordSetting from "./PasswordSetting";

export default {
    name: "ProfileSettingsComponent",
    components: {PasswordSetting, ContactSetting, PersonalDetails}
}
</script>

<style scoped>

</style>
