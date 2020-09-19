<template>
    <div>
        <b-autocomplete
            :data="search_results"
            placeholder="Search by name or mobile no"
            field="name"
            required
            :loading="loading"
            @typing="searchClients"
            @select="handleClientSelected">
            <template slot-scope="props">
                <ClientTile :client="props"/>
            </template>
            <template v-slot:empty>
                <p class="mb-0 py-2 cursor-pointer text-gray-700" @click="showAddNewClient">+ Add Client</p>
            </template>
        </b-autocomplete>
        <b-message v-model="show_add_new" class="mt-2 tracker-wider">
            <div>
                <p class="tracing-wider mb-2 uppercase text-sm">New Client</p>
                <div class="flex flex-row justify-content-between">
                    <b-input placeholder="Name" v-model="name" class="mb-1 mr-1" size="is-small"/>
                    <b-input placeholder="Mobile" v-model="mobile" class="ml-1" size="is-small"/>
                </div>
                <div class="flex flex-row-reverse mt-2">
                    <b-button size="is-small" rounded type="is-link " @click="handleAddNewClient">Add</b-button>
                    &nbsp;&nbsp;
                    <b-button size="is-small" rounded @click="show_add_new = false">Close</b-button>
                </div>
            </div>
        </b-message>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import ClientTile from "./ClientTile";

export default {
    name: "ClientDropdown",
    components: {
        ClientTile
    },
    data() {
        return {
            loading: false,
            search_results: [],
            selected: null,
            name: '',
            mobile: '',
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
        handleAddNewClient() {
            //axios call to create a client
            const new_client = {
                tenant_id: this.tenant_id,
                name: this.name,
                mobile: this.mobile,
                address_type: 'client'
            }
            this.show_add_new = false;
        },
        handleClientSelected(client) {
            if (client) {
                this.$emit('on-select', client)
            }
        }
    },
}
</script>

<style scoped>

</style>
