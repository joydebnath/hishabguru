<template>
    <div>
        <b-tag
            v-if="selected"
            attached
            closable
            size="is-medium"
            class="w-100"
            type="is-dark"
            @close="selected = null"
        >
            {{ selected.name }}
        </b-tag>
        <b-autocomplete
            v-else
            v-model="client_name"
            :data="search_results"
            placeholder="Search by name or mobile no"
            field="name"
            :loading="loading"
            clear-on-select
            @typing="searchClients"
            @select="handleClientSelected">
            <template slot-scope="props">
                <ClientTile :client="props"/>
            </template>
            <template v-slot:empty>
                <p class="mb-0 py-2 cursor-pointer text-gray-700" @click="showAddNewClient">
                    + Add Client {{ client_name }}
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
                <ClientAddNew :name="client_name" @on-close="show_add_new = false" @on-add="handleAddNewClient"/>
            </template>
        </b-modal>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import ClientTile from "./ClientTile";
import ClientAddNew from "./ClientAddNew";

export default {
    name: "ClientDropdown",
    components: {
        ClientAddNew,
        ClientTile
    },
    data() {
        return {
            loading: false,
            search_results: [],
            selected: null,
            client_name: '',
            show_add_new: false
        }
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant'
        })
    },
    methods: {
        searchClients(value) {
            this.loading = true;
            axios.get('/lookup/clients', {
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
                    console.log('searchClients => ', err)
                })
        },
        showAddNewClient() {
            this.show_add_new = true;
        },
        handleAddNewClient({name, mobile}) {
            //axios call to create a client
            const new_client = {
                tenant_id: this.tenant_id,
                name: name,
                mobile: mobile,
                address_type: 'client'
            }
            this.show_add_new = false;
        },
        handleClientSelected(client) {
            if (client) {
                this.selected = client;
                this.$emit('on-select', client)
            }
        }
    },
}
</script>

<style scoped>

</style>
