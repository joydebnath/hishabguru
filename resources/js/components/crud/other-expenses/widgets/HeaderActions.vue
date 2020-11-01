<template>
    <div class="flex flex-row justify-content-end mb-2" v-show="false">
        <b-tooltip label="Add Payment Record" position="is-right" type="is-dark">
            <b-button size="is-small" class="mx-2 font-semibold rounded-md" @click="$emit('on-add-payment')">+ Payment
            </b-button>
        </b-tooltip>
        <b-dropdown aria-role="list" append-to-body size="is-small" v-if="$props.show_option">
            <button class="button px-2 is-small rounded-md" slot="trigger" slot-scope="{ active }">
                <span class="font-semibold">Options</span>
                <b-icon :icon="active ? 'menu-up' : 'menu-down'"/>
            </button>
            <b-dropdown-item class="text-red-700" @click="handleDelete">
                Delete
            </b-dropdown-item>
        </b-dropdown>
        <DeleteBox
            :show="show_delete"
            :handler="onConfirmDelete"
            @on-close="handleDeleteClose"
        />
    </div>
</template>

<script>
import DeleteBox from "@/components/global/popups/DeleteBox";
import {remove} from '@/repos/other-expenses'

export default {
    name: "HeaderActions",
    components: {DeleteBox},
    props: {
        expense: Object | Array,
        show_option: {
            type: Boolean,
            default: true
        },
    },
    data() {
        return {
            show_delete: false,
        }
    },
    methods: {
        handleDelete() {
            this.show_delete = true
        },
        handleDeleteClose() {
            this.show_delete = false
        },
        onConfirmDelete() {
            this.$emit('on-loading', true);
            remove(this.$props.expense.id)
                .then(({data}) => {
                    this.$emit('on-loading', false);
                    this.$buefy.notification.open({
                        message: data.message,
                        type: 'is-success is-light',
                        duration: 5000
                    });
                    this.$store.commit('other_expenses/remove', {expense: this.$props.expense})
                    this.handleDeleteClose()
                    this.$router.push('/@/other-expenses');
                })
                .catch(err => {
                    console.log(err)
                    if (err.response) {
                        this.$buefy.notification.open({
                            message: err.response.data.message,
                            type: 'is-danger is-light',
                            duration: 5000
                        })
                    }
                    this.$emit('on-loading', false);
                    this.handleDeleteClose()
                })
        }
    }
}
</script>
