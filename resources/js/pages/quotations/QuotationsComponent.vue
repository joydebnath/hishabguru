<template>
    <div class="max-w-6xl m-auto w-full py-2">
        <div class="box pt-6">
            <b-field grouped group-multiline>
                <div class="flex flex-row justify-between pb-4 w-full">
                    <template v-if="show_bulk_actions">
                        <div>
                            <b-button size="is-small" type="is-danger is-light">Delete</b-button>
                        </div>
                    </template>
                    <template v-else>
                        <b-field grouped>
                            <SearchBox placeholder="Search by name" @search="handleSearch"/>
                            &nbsp;&nbsp;&nbsp;
                            <Filters/>
                        </b-field>
                    </template>

                    <section>
                        <router-link to="/@/quotations/create">
                            <button class="button field mr-3 is-info text-sm">
                                <span>New Quotation</span>
                            </button>
                        </router-link>
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
                <Table @on-delete="handleDelete" @on-share="handleShare"/>
            </keep-alive>
        </div>
        <DeleteBox
            :show="delete_popup"
            :handler="onConfirmDelete"
            @on-close="handleDeleteClose"
        />
        <CopyUrlBox
            title="Share Quotation Url"
            :show="share_url!== ''"
            :url="share_url"
            @on-close="handleShareClose"
        />
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import SearchBox from '@/components/global/SearchBox';
import Table from "./QuotationTable.vue";
import Filters from "./QuotationsFilters";
import RefreshIcon from "@/components/icons/RefreshIcon";
import DeleteBox from "@/components/global/popups/DeleteBox";
import CopyUrlBox from "@/components/global/popups/CopyUrlBox";
import {remove} from '@/repos/quotations'

export default {
    components: {
        CopyUrlBox,
        DeleteBox,
        RefreshIcon,
        Filters,
        Table,
        SearchBox
    },
    data() {
        return {
            delete_popup: false,
            share_url: '',
            tobe_deleted_quotation: {},
            tobe_shared_quotation: {},
        };
    },
    methods: {
        handleSearch(value) {
            this.$store.commit('quotations/setFilters', {
                filters: {
                    search: value
                }
            });
            this.$store.dispatch('quotations/loadData', {page: 1})
        },
        handleRefresh() {
            this.$store.dispatch('quotations/loadData', {page: this.current_page})
        },
        handleDelete(quotation) {
            this.delete_popup = true;
            this.tobe_deleted_quotation = quotation;
        },
        handleDeleteClose() {
            this.delete_popup = false;
            this.tobe_deleted_quotation = {};
        },
        handleShare(quotation) {
            const data = {
                type: 'quotation',
                id: quotation.id
            }

            this.share_url = 'www.hishabguru.com/share?q=' + btoa(JSON.stringify(data));
        },
        handleShareClose() {
            this.share_url = ''
        },
        onConfirmDelete() {
            this.$store.commit('quotations/setLoading', {loading: true})
            remove(this.tobe_deleted_quotation.id)
                .then(({data}) => {
                    this.$store.commit('quotations/setLoading', {loading: false})
                    this.$buefy.notification.open({
                        message: data.message,
                        type: 'is-success is-light',
                        duration: 5000
                    });
                    this.$store.dispatch('quotations/loadData', {page: this.current_page});
                    this.handleDeleteClose()
                })
                .catch(err => {
                    console.log(err)
                    if (err.response) {
                        this.$buefy.notification.open({
                            message: err.response.data.message,
                            type: 'is-danger is-light',
                            duration: 5000
                        })
                    }
                    this.$store.commit('quotations/setLoading', {loading: false});
                    this.handleDeleteClose()
                })
        }
    },
    computed: {
        ...mapGetters({
            checked_products: 'quotations/getCheckedQuotations',
            current_page: 'quotations/getCurrentPage',
        }),
        show_bulk_actions() {
            return this.checked_products.length
        },
    }
};
</script>
