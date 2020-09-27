<template>
    <b-modal
        v-model="$props.show"
        has-modal-card
        @on-cancel="$emit('on-close')"
        :destroy-on-hide="false"
    >
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
                <p class="modal-card-title text-base">Select Delivery Site Address</p>
                <button class="delete" @click="$emit('on-close')"></button>
            </header>
            <div class="modal-card-body" style="width: 700px">
                <div class="flex-row mb-2">
                    <SearchBox placeholder="Search by name" @search="handleSearch"/>
                </div>
                <b-table
                    :data="data"
                    :columns="columns"
                    :selected.sync="selected"
                    :paginated="true"
                    :per-page="perpage"
                    :current-page="currentPage"
                    :pagination-simple="false"
                >
                </b-table>
            </div>
            <footer class="modal-card-foot flex-row-reverse">
                <button class="button is-primary" type="button" @click="$emit('on-close')">Done</button>
            </footer>
        </div>
    </b-modal>
</template>

<script>
import SearchBox from "@/components/global/SearchBox";

export default {
    name: "SelectDeliverySite",
    components: {SearchBox},
    props: {
        show: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            data: [
                {'id': 1, 'site': 'Default Store', 'address': 'Simmons', 'type': 'Online'},
                {'id': 2, 'site': 'Default Store', 'address': 'Simmons', 'type': 'Online'},
                {'id': 3, 'site': 'Default Store', 'address': 'Simmons', 'type': 'Online'},
                {'id': 4, 'site': 'Default Store', 'address': 'Simmons', 'type': 'Online'},
                {'id': 5, 'site': 'Default Store', 'address': 'Simmons', 'type': 'Online'},
                {'id': 6, 'site': 'Default Store', 'address': 'Simmons', 'type': 'Online'},
            ],
            columns: [
                {
                    field: 'site',
                    label: 'Site name',
                    width: 150,
                },
                {
                    field: 'address',
                    label: 'Address',
                },
                {
                    field: 'type',
                    label: 'Type',
                    width: 100,
                },
            ],
            selected: null,
            perpage:3,
            currentPage: 1
        }
    },
    methods: {
        handleSearch(value) {

        }
    }
}
</script>

<style scoped>

</style>
