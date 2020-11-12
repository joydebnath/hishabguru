<template>
    <section class="pt-4 step-box">
        <div class="content has-text-centered mx-12">
            <p class="tracking-wider text-base leading-6 font-medium text-gray-900">
                Download our {{ type }} template file
            </p>
            <p class="p-6 bg-gray-100">
                Start by <strong>downloading</strong> our contacts CSV (Comma Separated Values) template file.
                This file has the correct column headings <span class="text-blue-500 font-medium tracking-wide">HishabGuru</span>
                needs to import your <span class="font-semibold text-gray-700">{{ type }}</span> data.
            </p>
            <p class="mt-6 flex flex-row justify-content-center">
                <a href="">
                    <span class="px-2 py-2 flex flex-row border align-items-center text-sm">
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
                        Download {{ type }} template file
                    </span>
                </a>
            </p>
        </div>
    </section>
</template>

<script>
export default {
    name: "DownloadTemplate",
    props: {
        type: String
    },
    data() {
        return {
            download_url_map: {
                products: '',
                clients: '',
                suppliers: '',
            }
        }
    }
}
</script>

<style scoped>

</style>
