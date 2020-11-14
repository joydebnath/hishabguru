<template>
    <section class="pt-4 step-box">
        <b-loading :is-full-page="true" v-model="loading" :can-cancel="false"/>
        <div class="content has-text-centered mx-12">
            <p class="tracking-wider text-base leading-6 font-medium text-gray-900">
                Upload the updated template file
            </p>
            <p class="p-6 bg-gray-100">
                The file you import must be a <strong class="text-orange-500">CSV (Comma Separated Values)</strong>
                file. The name of your file should end with either <strong>.csv</strong>
            </p>
            <p class="mt-6 flex flex-row justify-content-center">
                <b-upload v-model="file" @input="handleUpload" accept=".csv">
                    <section class="section border border-dashed cursor-pointer">
                        <div class="content has-text-centered">
                            <div class="d-inline-flex">
                                <svg class="w-5 h-5" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 14V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V14"
                                          stroke="#000" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                    <path d="M12 17V3M12 3L7 8.44446M12 3L17 8.44444" stroke="#000" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                            <div>Drop your files here or click to upload</div>
                        </div>
                    </section>
                </b-upload>
            </p>
            <div class="mt-6 flex flex-row justify-content-center">
                <p v-if="file" class="px-2 py-2 flex flex-row border align-items-center text-sm">
                    <svg class="w-5 h-5 mr-1" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6 22H18C19.1046 22 20 21.1046 20 20V9.82843C20 9.29799 19.7893 8.78929 19.4142 8.41421L13.5858 2.58579C13.2107 2.21071 12.702 2 12.1716 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22Z"
                            stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path
                            d="M13 2.5V9H19" stroke="#000" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M8 17H15" stroke="#000" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"></path>
                        <path
                            d="M8 13H15" stroke="#000" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M8 9H9" stroke="#000" stroke-width="1.5"
                              stroke-linecap="round"
                              stroke-linejoin="round"></path>
                    </svg>
                    {{ file.name }}
                    <button class="delete is-small ml-2"
                            type="button"
                            @click="deleteDropFile">
                    </button>
                </p>
            </div>
        </div>
    </section>
</template>

<script>
import Para from 'papaparse'
import {mapGetters} from 'vuex'

export default {
    name: "UploadTemplate",
    props: {
        type: String
    },
    data() {
        return {
            file: null,
            records: [],
            loading: false,
        }
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant'
        })
    },
    methods: {
        handleUpload(file) {
            this.records = [];

            if (!this.validateFileName(file)) {
                return false
            }

            this.parseCSVFile(file)
        },
        parseCSVFile(file) {
            this.loading = true
            let uid = 1
            Para.parse(file, {
                header: true,
                worker: true,
                skipEmptyLines: true,
                complete: (results, file) => {
                    if (!this.records.length) {
                        this.$buefy.snackbar.open({
                            message: 'The uploaded file has no records',
                            type: 'is-warning',
                            position: 'is-top',
                            actionText: 'Ok',
                            duration: 5000
                        })
                        this.deleteDropFile()
                    }
                    this.$emit('on-complete', this.records)
                    this.loading = false
                },
                step: (results, parser) => {
                    let {data, errors} = results
                    if (!errors.length) {
                        this.records.push({...data, uid: uid, tenant_id: this.tenant_id})
                        uid += 1;
                    }
                },
                error: (error, file) => {
                    console.log("ERROR:", error);
                    this.loading = false
                    this.onError('Whoops! Unable to parse the file.')
                }
            })
        },
        deleteDropFile() {
            this.file = null
        },
        validateFileName(file) {
            if (file.name.indexOf(this.$props.type) === -1) {
                this.onError('File name does not match with selected type: ' + this.type)
                this.deleteDropFile();
                return false;
            }
            return true;
        },
        onError(message) {
            this.$buefy.snackbar.open({
                duration: 5000,
                message: message,
                type: 'is-danger',
                position: 'is-top-right',
            })
        }
    }
}
</script>
