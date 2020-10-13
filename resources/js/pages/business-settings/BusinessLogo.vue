<template>
    <ActionForm action_name="Brand Logo" action_description="Brand Logo makes your document look professional.">
        <template>
            <div class="grid grid-cols-5 gap-4">
                <div class="col-span-2 m-auto">
                    <b-field class="file is-light" :class="{'has-name': !!image}">
                        <b-upload v-model="image" class="file-label">
                        <span class="file-cta">
                            <CameraIcon></CameraIcon>
                            <span class="file-label text-sm px-2">Click to Upload</span>
                        </span>
                        </b-upload>
                    </b-field>
                </div>
                <div class="col-span-3 px-16">
                    <b-image
                        v-if="image"
                        accept="image/*"
                        :src="image.url"
                        placeholder="https://bulma.io/images/placeholders/128x128.png"
                        ratio="3by2"
                    ></b-image>
                    <div v-else class="border text-center p-16 text-capitalize flex m-auto flex-col align-items-center">
                        <svg width="24" class="m-auto h-8 w-8" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21 21H4C2.89543 21 2 20.1046 2 19V8.6C2 7.49543 2.89543 6.6 4 6.6L6 6.6M9.5 3H14.5L17 6.6L20 6.6C21.1046 6.6 22 7.49543 22 8.6V16"
                                stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path
                                d="M9.66498 9.75195C8.65655 10.4782 8 11.6624 8 13C8 15.2092 9.79086 17 12 17C13.2632 17 14.3896 16.4145 15.1227 15.5"
                                stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M2 2L22 22" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <p class="text-sm text-gray-700 py-1">No image</p>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <b-button class="text-sm mr-4 rounded tracking-wider font-medium" @click="handleRemove">
                Remove
            </b-button>
            <b-button type="is-info" class="text-sm rounded tracking-wider font-medium" @click="handleSave">
                Save
            </b-button>
        </template>
    </ActionForm>
</template>

<script>
import ActionForm from "@/components/global/form/ActionForm";
import CameraIcon from "@/components/icons/CameraIcon";

export default {
    name: "BusinessLogo",
    components: {CameraIcon, ActionForm},
    data() {
        return {
            image: null
        }
    },
    methods: {
        handleRemove() {

        },
        handleSave() {

        }
    },
    watch: {
        image(val) {
            console.log(val)
        }
    }
}
</script>
