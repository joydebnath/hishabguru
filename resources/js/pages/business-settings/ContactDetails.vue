<template>
    <ActionForm action_name="Contact Details" action_description="Keep your business contact details upto date">
        <PhysicalAddress :address="computed_items.headquarter" ref="hq"/>
        <div class="grid grid-cols-5 border-b my-4"></div>
        <div class="grid grid-cols-5">
            <div class="col-span-3">
                <b-field label="Phone Number" custom-class="text-sm">
                    <b-input custom-class="text-sm" v-model="computed_items.phone"></b-input>
                </b-field>
                <b-field label="Email" custom-class="text-sm">
                    <b-input custom-class="text-sm" v-model="computed_items.email"></b-input>
                </b-field>
                <b-field label="Website" custom-class="text-sm">
                    <b-input custom-class="text-sm" v-model="computed_items.website"></b-input>
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
import PostalAddress from "./widgets/PostalAddress";
import PhysicalAddress from "./widgets/PhysicalAddress";
import {mapGetters} from "vuex";

export default {
    name: "BusinessDetails",
    components: {PhysicalAddress, PostalAddress, ActionForm},
    props: {
        fields: Object | Array
    },
    data() {
        return {
            items: {}
        }
    },
    methods: {
        handleUpdate() {
            this.loading = true;
            axios
                .patch('/business-settings/' + this.tenant_id, {
                    ...this.computed_items,
                    headquarter: {...this.$refs.hq.collect()},
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
    }
}
</script>

<style scoped>

</style>
