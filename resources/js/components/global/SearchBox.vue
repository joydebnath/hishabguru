<template>
    <b-field>
        <b-input
            icon="magnify"
            custom-class="is-info"
            v-model="string"
            :placeholder="$props.placeholder"
            @keyup.enter.native="handleSearchEmit"
            @icon-right-click="handleClear"
            icon-right="close text-xs"
            icon-right-clickable
        />
        <p class="control">
            <button class="button is-info" @click="handleSearchEmit" >
                Search
            </button>
        </p>
    </b-field>
</template>

<script>
export default {
    props: {
        placeholder: {
            type: String,
            default: "Search ..."
        }
    },
    data() {
        return {
            string: ""
        };
    },
    methods:{
        handleSearchEmit(){
            this.$emit('search', this.string)
        },
        handleClear(){
            if(this.string === ''){
                return
            }
            this.string = '';
            this.handleSearchEmit()
        }
    }
};
</script>

<style></style>
