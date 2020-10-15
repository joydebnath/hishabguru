<template>
    <ActionForm action_name="Business Details" action_description="Keep your business details upto date">
        <template>
            <div class="grid grid-cols-5">
                <div class="col-span-3">
                    <b-field label="Name" custom-class="text-sm">
                        <b-input custom-class="text-sm" v-model="computed_items.name"></b-input>
                    </b-field>
                    <b-field label="What is your line of business?" custom-class="text-sm">
                        <b-input custom-class="text-sm" placeholder="e.g. Online Retail, Restaurant"
                                 v-model="computed_items.business_type"></b-input>
                    </b-field>
                    <b-field label="Tax File Number" custom-class="text-sm">
                        <b-input custom-class="text-sm" v-model="computed_items.tax_file_number"></b-input>
                    </b-field>
                    <b-field label="Description" custom-class="text-sm">
                        <b-input type="textarea" :rows="3" maxlength="250" custom-class="text-sm"
                                 v-model="computed_items.description"></b-input>
                    </b-field>
                </div>
            </div>
        </template>
        <template #footer>
            <b-button type="is-info" :loading="loading" class="text-sm rounded tracking-wider font-medium"
                      @click="handleUpdate">
                Update
            </b-button>
        </template>
    </ActionForm>
</template>

<script>
import {mapGetters} from 'vuex';
import ActionForm from "@/components/global/form/ActionForm";

export default {
    name: "BusinessDetails",
    components: {ActionForm},
    props: {
        fields: Object | Array
    },
    data() {
        return {
            items: {},
            loading: false
        }
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant'
        }),
        computed_items() {
            if (this.$props.fields) {
                this.items = {...this.$props.fields}
            }
            return this.items
        }
    },
    methods: {
        handleUpdate() {
            this.loading = true;
            axios
                .patch('/business-settings/' + this.tenant_id, {...this.computed_items, type: 'business-details'})
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
