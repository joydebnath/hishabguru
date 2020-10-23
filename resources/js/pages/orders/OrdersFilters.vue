<template>
    <FilterComponent @apply="handleApplyFilter" @clear="handleClearFilter">
        <p>
            <b-skeleton active/>
            <b-skeleton height="80px"/>
        </p>
    </FilterComponent>
</template>

<script>
import FilterComponent from "@/components/global/filter/Filter";
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
