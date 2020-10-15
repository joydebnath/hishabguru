<template>
    <ActionForm
        action_name="Operation Details"
        action_description="Keep your business operation details updated to generate correct documents"
    >
        <template>
            <div class="grid grid-cols-5">
                <div class="col-span-4">
                    <b-field grouped>
                        <b-field label="Business Country" custom-class="text-sm">
                            <b-input custom-class="text-sm" v-model="computed_items.country"></b-input>
                        </b-field>
                        <b-field label="Currency" custom-class="text-sm">
                            <b-input custom-class="text-sm" v-model="computed_items.currency"></b-input>
                        </b-field>
                    </b-field>
                </div>
            </div>
        </template>
        <template #footer>
            <b-button type="is-info"
                      :loading="loading"
                      class="text-sm rounded tracking-wider font-medium" @click="handleUpdate"
            >
                Update
            </b-button>
        </template>
    </ActionForm>
</template>

<script>
import ActionForm from "@/components/global/form/ActionForm";
import {mapGetters} from "vuex";

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
    methods: {
        handleUpdate() {
            this.loading = true;
            axios
                .patch('/business-settings/' + this.tenant_id, {...this.computed_items, type: 'operation-details'})
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
