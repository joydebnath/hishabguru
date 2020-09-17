<template>
    <FilterComponent @apply="handleApplyFilter" @clear="handleClearFilter">
        <template >
            <div class="border-b pb-2">
                <p
                    class="font-semibold text-gray-700 mb-3 uppercase tracking-wide"
                >
                    Name
                </p>
                <b-checkbox v-model="checkboxGroup" native-value="Silver">
                    Silver
                </b-checkbox>
                <b-checkbox v-model="checkboxGroup" native-value="Flint">
                    Flint
                </b-checkbox>
                <b-checkbox v-model="checkboxGroup" native-value="Vane">
                    Vane
                </b-checkbox>
                <b-checkbox
                    v-model="checkboxGroup"
                    native-value="Billy"
                    disabled
                >
                    Billy
                </b-checkbox>
            </div>
        </template>
    </FilterComponent>
</template>

<script>
import FilterComponent from "../global/filter/Filter";
export default {
    components: {
        FilterComponent
    },
    data(){
        return {
            checkboxGroup: []
        }
    },
    methods:{
        handleApplyFilter(){

        },
        handleClearFilter(){

        }
    }
};
</script>

<style></style>
