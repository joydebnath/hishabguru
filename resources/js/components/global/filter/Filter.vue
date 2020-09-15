<template>
    <div class="custom-filter">
        <b-dropdown aria-role="list" :close-on-click="false">
            <button
                class="button text-gray-800 is-outlined is-info hover:text-white focus:text-white text-blue-600"
                slot="trigger"
            >
                <svg
                    width="16"
                    hight="16"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z"
                    />
                </svg>
                <span class="ml-2">Filters</span>
            </button>
            <div class="modal-card w-full">
                <section class="modal-card-body">
                    <slot></slot>
                </section>
                <footer class="modal-card-foot bg-white p-4 flex justify-content-end">
                    <button class="button is-primary" @click="$emit('apply')">
                        Apply
                    </button>
                    <button class="button is-light" @click="$emit('clear')">
                        Clear
                    </button>
                </footer>
            </div>
        </b-dropdown>
    </div>
</template>

<script>
export default {
    data() {
        return {
            checkboxGroup: []
        };
    }
};
</script>

<style>
.custom-filter .dropdown-menu {
    padding: 0 !important;
    width: 500px;
}
.custom-filter .dropdown-content {
    padding: 0;
}
</style>
