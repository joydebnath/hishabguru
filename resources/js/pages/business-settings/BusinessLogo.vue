<template>
    <ActionForm action_name="Brand Logo" action_description="Brand Logo makes your document look professional.">
        <template>
            <div class="grid grid-cols-5 gap-4">
                <div class="col-span-2 m-auto">
                    <b-field class="file is-light" :class="{'has-name': !!image}">
                        <b-upload type="file" v-model="image" class="file-label"
                                  accept="image/png,image/jpg,image/jpeg">
                            <span class="file-cta">
                                <CameraIcon></CameraIcon>
                                <span class="file-label text-sm px-2">Click to Upload</span>
                            </span>
                        </b-upload>
                    </b-field>
                </div>
                <div class="col-span-3 px-16">
                    <b-skeleton height="195px" v-if="$props.loading"/>
                    <template v-else>
                        <b-image
                            v-if="computed_logo"
                            :src="computed_logo"
                            ratio="3by2"
                        />
                        <div v-else
                             class="border text-center p-16 text-capitalize flex m-auto flex-col align-items-center">
                            <svg width="24" class="m-auto h-8 w-8" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21 21H4C2.89543 21 2 20.1046 2 19V8.6C2 7.49543 2.89543 6.6 4 6.6L6 6.6M9.5 3H14.5L17 6.6L20 6.6C21.1046 6.6 22 7.49543 22 8.6V16"
                                    stroke="#000" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path
                                    d="M9.66498 9.75195C8.65655 10.4782 8 11.6624 8 13C8 15.2092 9.79086 17 12 17C13.2632 17 14.3896 16.4145 15.1227 15.5"
                                    stroke="#000" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path d="M2 2L22 22" stroke="#000" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                            </svg>
                            <p class="text-sm text-gray-700 py-1">No image</p>
                        </div>
                    </template>
                </div>
            </div>
        </template>
        <template #footer>
            <b-button class="text-sm mr-4 rounded tracking-wider font-medium" v-if="image" @click="handleRemove">
                Remove
            </b-button>
            <b-button
                :disabled="image === null"
                type="is-info"
                class="text-sm rounded tracking-wider font-medium"
                @click="handleSave"
            >
                Save
            </b-button>
        </template>
    </ActionForm>
</template>

<script>
import {mapGetters} from 'vuex';
import ActionForm from "@/components/global/form/ActionForm";
import CameraIcon from "@/components/icons/CameraIcon";

export default {
    name: "BusinessLogo",
    components: {CameraIcon, ActionForm},
    props: {
        logo: String,
        loading: Boolean
    },
    data() {
        return {
            image: null,
            image_data: null
        }
    },
    methods: {
        handleRemove() {
            this.image = null
            this.image_data = null
        },
        handleSave() {
            let formData = new FormData();
            formData.append("image", this.image);
            formData.append("imageable_type", 'tenants');
            formData.append("imageable_id", this.tenant_id);
            axios
                .post('/upload/image', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(({data}) => {
                    this.image = null
                    this.image_data = data.logo
                })
                .catch(err => {
                    console.log(err)
                })
        },
        isValidFileSize(file) {
            if (file.size === undefined) {
                return false;
            }
            return !(file.size && file.size > 1250000);
        }
    },
    computed: {
        ...mapGetters({
            tenant_id: 'tenancy/getCurrentTenant'
        }),
        computed_logo() {
            return this.image_data
        }
    },
    watch: {
        logo(value) {
            if (value) {
                this.image_data = value
            }
        },
        image(file) {
            if (file && this.isValidFileSize(file)) {
                console.log(file)
                this.image_data = URL.createObjectURL(file);
                return 0;
            }
            if (file && file.size > 1250000) {
                this.$buefy.snackbar.open({
                    message: 'Image <span class="font-semibold">size</span> should be less than <span class="font-semibold">1.25Mb</span>',
                    type: 'is-warning',
                    position: 'is-top',
                    actionText: 'OK',
                    duration: 6000,
                })
                this.image = null
            }
        }
    }
}
</script>
