<template>
    <div class="max-w-6xl m-auto w-full py-2">
        <div class="box pt-6">
            <b-field grouped group-multiline>
                <div class="flex flex-row justify-between pb-4 w-full">
                    <b-field grouped>
                        <SearchBox placeholder="Search by name" @search="handleSearch"/>
                        &nbsp;&nbsp;&nbsp;
                        <Filters/>
                    </b-field>
                    <section>
                        <button class="button field is-info text-sm" @click="handleAdd">
                            <span>New Client</span>
                        </button>
                        <b-tooltip label="Refresh" type="is-dark" content-class="tracking-wider">
                            <button class="button field text-sm px-2">
                                <RefreshIcon/>
                            </button>
                        </b-tooltip>
                    </section>
                </div>
            </b-field>
            <div class="border-b my-4"></div>
            <keep-alive>
                <Table @on-edit="handleEdit" @on-delete="handleDelete"/>
            </keep-alive>
        </div>
        <ItemCRUD
            :show="show_modal"
            :action_type="action_name"
            :item="computed_client"
            :loading="computed_loading"
            @on-close="handleToggleModal"
            @on-loading="handleToggleLoading"
        />
        <DeleteBox
            :show="delete_popup"
            :handler="onConfirmDelete"
            @on-close="handleCloseDelete"
        />
    </div>
</template>
<script>
import {mapMutations} from "vuex";
import SearchBox from '@/components/global/SearchBox'
import Table from "./ClientsTable.vue";
import Filters from "./ClientsFilters";
import ItemCRUD from "./modals/ItemCRUD";
import RefreshIcon from "@/components/icons/RefreshIcon";
import DeleteBox from "@/components/global/popups/DeleteBox";

export default {
    components: {
        DeleteBox,
        RefreshIcon,
        Filters,
        ItemCRUD,
        Table,
        SearchBox,
    },
    data() {
        return {
            show_modal: false,
            action_type: 'add',
            loading: false,
            client: {},
            delete_popup: false,
            tobe_deleted_client: {}
        };
    },
    methods: {
        ...mapMutations({
            setFilters: 'clients/setFilters'
        }),
        handleToggleModal() {
            this.show_modal = !this.show_modal;
            this.client = {};
        },
        handleSearch(value) {
            this.setFilters({
                filters: {search: value}
            })
            this.$store.dispatch('clients/loadData', {page: 1})
        },
        handleAdd() {
            this.action_type = 'add';
            this.handleToggleModal()
        },
        handleEdit(client) {
            this.action_type = 'edit';
            this.handleToggleModal()
            this.loading = true;
            axios
                .get('/clients/' + client.id)
                .then(({data}) => {
                    this.loading = false;
                    this.client = data.data
                })
                .catch(err => {
                    this.loading = false;
                })
        },
        handleDelete(client) {
            this.delete_popup = true;
            this.tobe_deleted_client = client;
        },
        onConfirmDelete() {
            axios
                .delete('/clients/' + this.tobe_deleted_client.id)
                .then(({data}) => {
                    this.$store.dispatch('clients/loadData', {
                        page: this.$store.getters['clients/getCurrentPage']
                    })
                    this.$buefy.notification.open({
                        message: data.message,
                        type: 'is-success is-light',
                        duration: 5000
                    })
                    this.handleCloseDelete();
                })
                .catch(err => {
                    if (err.response) {
                        this.$buefy.notification.open({
                            message: err.response.data.message,
                            type: 'is-danger is-light',
                            duration: 5000
                        })
                    }
                    this.handleCloseDelete();
                })
        },
        handleCloseDelete() {
            this.delete_popup = false;
            this.tobe_deleted_client = {};
        },
        handleToggleLoading(value) {
            this.loading = value
        },
    },
    computed: {
        action_name() {
            return this.action_type
        },
        computed_loading() {
            return this.loading
        },
        computed_client() {
            return this.client
        }
    }
};
</script>
