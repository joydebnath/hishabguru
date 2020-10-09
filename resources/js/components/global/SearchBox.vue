<template>
    <b-field>
        <b-input
            custom-class="is-info text-sm"
            v-model="string"
            :placeholder="$props.placeholder"
            @keyup.enter.native="handleSearchEmit"
            @icon-right-click="handleClear"
            icon-right="close text-xs -mt-1"
            icon-right-clickable
        />
        <p class="control">
            <b-button class="text-sm" type="is-info" @click="handleSearchEmit" >
                <b-icon icon="magnify" custom-class="-mb-3"/>
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
