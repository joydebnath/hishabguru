<template>
    <section class="max-w-6xl m-auto w-full py-2">
        <b-loading :is-full-page="true" v-model="loading" :can-cancel="false">
            <b-progress :value="upload_progress" class="w-48" type="is-success" size="is-small"/>
        </b-loading>

        <div class="box pt-6">
            <b-steps
                type="is-info"
                size="is-small"
                v-model="activeStep"
                label-position="bottom"
                class="mt-4"
                mobile-mode="minimalist"
                :animated="true"
                :rounded="true"
                :has-navigation="true"
            >
                <b-step-item step="1" label="Import Type" :clickable="false">
                    <ImportType @on-select="handleTypeSelected"/>
                </b-step-item>
                <b-step-item step="2" label="Download Template" :clickable="false">
                    <DownloadTemplate :type="type"/>
                </b-step-item>
                <b-step-item step="3" label="Upload Template" :clickable="false">
                    <UploadTemplate :type="type" @on-complete="handleCSVParsed"/>
                </b-step-item>
                <b-step-item step="4" label="Confirmation" :clickable="false">
                    <Confirmation :type="type" :records="computed_records"/>
                </b-step-item>
                <template
                    slot="navigation"
                    slot-scope="{previous, next}">
                    <div class="flex flex-row justify-content-between px-4 pt-4 border-top">
                        <b-button
                            type="is-dark"
                            outlined
                            size="is-small"
                            :disabled="previous.disabled"
                            @click.prevent="previous.action"
                            v-text="'Go back'"
                        />

                        <b-button
                            v-if="!next.disabled"
                            type="is-dark"
                            size="is-small"
                            outlined
                            v-text="'Next'"
                            :disabled="next.disabled || !type"
                            @click.prevent="next.action"
                        />

                        <b-button
                            v-if="next.disabled"
                            type="is-primary"
                            size="is-small"
                            @click.prevent="handleComplete"
                            :disabled="!records.length"
                            v-text="'Create'"
                        />
                    </div>
                </template>
            </b-steps>
        </div>
    </section>
</template>

<script>
import ImportType from "./widgets/ImportType";
import DownloadTemplate from "./widgets/DownloadTemplate";
import UploadTemplate from "./widgets/UploadTemplate";
import Confirmation from "./widgets/Confirmation";

export default {
    name: "ImportComponent",
    components: {Confirmation, UploadTemplate, DownloadTemplate, ImportType},
    data() {
        return {
            activeStep: 0,
            type: '',
            records: [],
            loading: false,
            progress: 0
        }
    },
    computed: {
        computed_records() {
            return this.records
        },
        upload_progress() {
            return this.progress
        }
    },
    methods: {
        handleTypeSelected(type) {
            this.type = type
        },
        handleCSVParsed(records) {
            this.records = records
        },
        goto() {
            const temp = this.type;
            this.type = ''
            this.$router.push('/@/' + temp);
        },
        handleComplete() {
            this.loading = true
            _.forEach(
                _.chunk(this.records, 25), records => {
                    axios
                        .post('/import-data', {
                            type: this.type,
                            records: records
                        })
                        .then(({data}) => {
                            if (this.progress === 100) {
                                this.loading = false
                            }
                        })
                        .catch(err => {
                            this.loading = false
                        })
                }
            )
        }
    }
}
</script>
<style>
.step-details {
    margin-top: 7px;
}

.step-box {
    min-height: 400px
}
</style>
