<template>
    <div>
        <b-tag
            v-if="$props.selected"
            attached
            :closable="!$props.read_only"
            size="is-medium"
            class="w-100"
            type="is-dark"
            @close="$emit('on-select',null)"
        >
            {{ $props.selected.name }}
        </b-tag>
        <b-autocomplete
            v-else
            v-model="supplier_name"
            :data="search_results"
            placeholder="Search by name or mobile no"
            field="name"
            :loading="loading"
            custom-class="text-sm"
            clear-on-select
            @typing="searchSuppliers"
            @select="handleClientSelected">
            <template slot-scope="props">
                <SupplierTile :supplier="props"/>
            </template>
            <template v-slot:empty>
                <!--                <p class="mb-0 py-2 cursor-pointer text-gray-700" @click="showAddNewClient">-->
                <!--                    + Add Client {{ supplier_name }}-->
                <!--                </p>-->
                <p class="mb-0 py-2 cursor-pointer text-gray-700">
                    Supplier {{ supplier_name }} not found
                </p>
            </template>
        </b-autocomplete>
        <b-modal
            v-model="show_add_new"
            has-modal-card
            trap-focus
            :destroy-on-hide="false"
            aria-role="dialog"
            aria-modal>
            <template #default="props">
                <AddNewSupplier :name="supplier_name" @on-close="show_add_new = false" @on-add="handleAddNewClient"/>
            </template>
        </b-modal>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import SupplierTile from "./SupplierTile";
import AddNewSupplier from "./AddNewSupplier";

export default {
    name: "SupplierLookupInput",
    props: {
        selected: Object,
        read_only: {
            type: Boolean,
            default: false
        }
    },
    components: {
        AddNewSupplier,
        SupplierTile
    },
    data() {
        return {
            loading: false,
            search_results: [],
            supplier_name: '',
            show_add_new: false
        }
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant'
        })
    },
    methods: {
        searchSuppliers(value) {
            this.loading = true;
            axios.get('/lookup/suppliers', {
                params: {
                    search: value,
                    tenant_id: this.tenant_id
                }
            })
                .then(({data}) => {
                    this.name = value;
                    this.loading = false;
                    this.search_results = data.data;
                })
                .catch(err => {
                    this.loading = false;
                    console.log('searchSuppliers => ', err)
                })
        },
        showAddNewClient() {
            this.show_add_new = true;
        },
        handleAddNewClient({name, mobile}) {
            //axios call to create a supplier
            const new_supplier = {
                tenant_id: this.tenant_id,
                name: name,
                mobile: mobile,
                address_type: 'supplier'
            }
            this.show_add_new = false;
        },
        handleClientSelected(supplier) {
            if (supplier) {
                this.$emit('on-select', supplier)
            }
            this.supplier_name = ''
        }
    },
}
</script>

<style scoped>

</style>
