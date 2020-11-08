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
                            <span>New Employee</span>
                        </button>
                        <b-tooltip label="Refresh" type="is-dark" content-class="tracking-wider">
                            <button class="button field text-sm px-2" @click="handleRefresh">
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
            :item="computed_employee"
            :loading="computed_loading"
            @on-close="handleToggleModal"
            @on-loading="handleToggleLoading"
        />
        <DeleteBox
            :show="delete_popup"
            :handler="onConfirmDelete"
            @on-close="handleDeleteClose"
        />
    </div>
</template>
<script>
import {mapMutations, mapGetters} from "vuex";
import SearchBox from '@/components/global/SearchBox'
import Table from "./EmployeesTable.vue";
import Filters from "./EmployeeFilters";
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
            employee: {},
            delete_popup: false,
            tobe_deleted_employee: {}
        };
    },
    methods: {
        ...mapMutations({
            appendFilter: 'employees/appendFilter'
        }),
        handleToggleModal() {
            this.show_modal = !this.show_modal;
            this.employee = {};
        },
        handleSearch(value) {
            this.appendFilter({
                filters: {search: value}
            })
            this.$store.dispatch('employees/loadData', {page: 1})
        },
        handleRefresh(){
            this.$store.dispatch('employees/loadData', {page: this.current_page})
        },
        handleAdd() {
            this.action_type = 'add';
            this.handleToggleModal()
        },
        handleEdit(employee) {
            this.action_type = 'edit';
            this.handleToggleModal()
            this.loading = true;
            axios
                .get('/employees/' + employee.id)
                .then(({data}) => {
                    this.loading = false;
                    this.employee = data.data
                })
                .catch(err => {
                    this.loading = false;
                })
        },
        handleDelete(employee) {
            this.delete_popup = true;
            this.tobe_deleted_employee = employee
        },
        handleDeleteClose() {
            this.delete_popup = false;
            this.tobe_deleted_employee = {}
        },
        onConfirmDelete() {
            axios
                .delete('/employees/' + this.tobe_deleted_employee.id)
                .then(({data}) => {
                    this.$store.dispatch('employees/loadData', {
                        page: this.current_page
                    })
                    this.$buefy.notification.open({
                        message: data.message,
                        type: 'is-success is-light',
                        duration: 5000
                    });
                    this.handleDeleteClose()
                })
                .catch(err => {
                    if (err.response) {
                        this.$buefy.notification.open({
                            message: err.response.data.message,
                            type: 'is-danger is-light',
                            duration: 5000
                        });
                        this.handleDeleteClose()
                    }
                })
        },
        handleToggleLoading(value) {
            this.loading = value
        },
    },
    computed: {
        ...mapGetters({
            current_page: 'employees/getCurrentPage'
        }),
        action_name() {
            return this.action_type
        },
        computed_loading() {
            return this.loading
        },
        computed_employee() {
            return this.employee
        }
    }
};
</script>
