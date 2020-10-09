<template>
    <b-field>
        <b-input
            custom-class="is-info"
            v-model="string"
            :placeholder="$props.placeholder"
            @keyup.enter.native="handleSearchEmit"
            @icon-right-click="handleClear"
            icon-right="close text-xs"
            icon-right-clickable
        />
        <p class="control">
            <b-button type="is-info" @click="handleSearchEmit" >
                <b-icon icon="magnify"/>
            </b-button>
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
