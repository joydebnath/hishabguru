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
                    <button class="button field is-info text-sm" @click="handleAdd">
                        <span>New Employee</span>
                    </button>
                </div>
            </b-field>
            <div class="border-b my-4"></div>
            <keep-alive>
                <Table @on-edit="handleEdit" @on-delete="handleDelete" />
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
    </div>
</template>
<script>
import {mapMutations} from "vuex";
import SearchBox from '@/components/global/SearchBox'
import Table from "./EmployeesTable.vue";
import Filters from "./EmployeeFilters";
import ItemCRUD from "./modals/ItemCRUD";

export default {
    components: {
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
            employee: {}
        };
    },
    methods: {
        ...mapMutations({
            setFilters: 'employees/setFilters'
        }),
        handleToggleModal() {
            this.show_modal = !this.show_modal;
            this.employee = {};
        },
        handleSearch(value) {
            this.setFilters({
                filters: {search: value}
            })
            this.$store.dispatch('employees/loadData', {page: 1})
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
            this.$buefy.dialog.confirm({
                message: '<h5 class="mb-2 font-medium text-xl">Deleting Employee</h5>Are you sure you want to delete the employee: <b>' + employee.name + '</b> ?',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => {
                    axios
                        .delete('/employees/' + employee.id)
                        .then(({data}) => {
                            this.$store.dispatch('employees/loadData', {
                                page: this.$store.getters['employees/getCurrentPage']
                            })
                            this.$buefy.notification.open({
                                message: data.message,
                                type: 'is-success is-light',
                                duration: 5000
                            })
                        })
                        .catch(err => {
                            if (err.response) {
                                this.$buefy.notification.open({
                                    message: err.response.data.message,
                                    type: 'is-danger is-light',
                                    duration: 5000
                                })
                            }
                        })
                }
            })
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
        computed_employee() {
            return this.employee
        }
    }
};
</script>
