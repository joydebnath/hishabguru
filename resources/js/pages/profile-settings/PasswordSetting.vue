<template>
    <ActionForm action_name="Password Change"
                action_description="Keep your password secure and do not share with others">
        <div class="grid grid-cols-5">
            <div class="col-span-3">
                <b-field label="Current Password" custom-class="text-sm" class="pwd">
                    <b-input custom-class="text-sm" type="password" password-reveal v-model="current_password"/>
                </b-field>
                <b-field label="New Password" custom-class="text-sm" class="pwd">
                    <b-input custom-class="text-sm" type="password" password-reveal v-model="new_password"/>
                </b-field>
                <b-field label="Confirm New Password" custom-class="text-sm" class="pwd">
                    <b-input custom-class="text-sm" type="password" password-reveal v-model="new_password_confirmed"/>
                </b-field>
            </div>
        </div>
        <template #footer>
            <b-button type="is-info" class="text-sm rounded tracking-wider font-medium" @click="handleUpdate">
                Update
            </b-button>
        </template>
    </ActionForm>
</template>

<script>
import ActionForm from "@/components/global/form/ActionForm";

export default {
    name: "PasswordSetting",
    components: {ActionForm},
    data() {
        return {
            current_password: '',
            new_password: '',
            new_password_confirmed: '',
            loading: false
        }
    },
    methods: {
        handleUpdate() {
            this.loading = true;
            axios
                .patch('/change-password', {
                    current_password: this.current_password,
                    new_password: this.new_password,
                    new_password_confirmed: this.new_password_confirmed,
                })
                .then(({data}) => {
                    this.loading = false;
                    this.current_password = '';
                    this.new_password = '';
                    this.new_password_confirmed = '';
                })
                .catch(err => {
                    console.log(err)
                    this.loading = false;
                })
        }
    }
}
</script>

<style>
.pwd .icon {
    color: rgba(74, 85, 104, .75) !important;
}
</style>
