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
<!--                <div class="flex-row mb-2">-->
<!--                    <SearchBox placeholder="Search by name" @search="handleSearch"/>-->
<!--                </div>-->
                <b-table
                    :data="sites"
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
import {mapGetters} from 'vuex';
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
            columns: [
                {
                    field: 'name',
                    label: 'Site name',
                    width: 150,
                },
                {
                    field: 'formatted_address',
                    label: 'Address',
                },
                {
                    field: 'address_type',
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
    },
    computed:{
        ...mapGetters({
            sites: 'tenancy/getCurrentInventories'
        })
    },
    watch:{
        selected(new_value, old_value){
            if(new_value !== old_value){
                this.$emit('on-select', new_value)
            }
        }
    }
}
</script>

<style scoped>

</style>
